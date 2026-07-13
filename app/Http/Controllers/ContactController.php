<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryConfirmation;
use App\Mail\ContactInquiryNotification;
use App\Models\ContactInquiry;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    private const SUCCESS_MESSAGE = 'Tak for din besked! Vi vender tilbage til dig hurtigst muligt.';

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website' => ['nullable', 'string', 'max:255'],
            'form_started_at' => ['nullable', 'integer'],
            'terms' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Navn er påkrævet.',
            'email.required' => 'E-mail er påkrævet.',
            'email.email' => 'Angiv en gyldig e-mailadresse.',
            'subject.required' => 'Emne er påkrævet.',
            'message.required' => 'Besked er påkrævet.',
            'message.min' => 'Beskeden skal være mindst 10 tegn.',
        ]);

        $rateLimitKeys = $this->rateLimitKeys($request, $validated['email']);

        if ($this->tooManySubmissions($rateLimitKeys)) {
            return back()
                ->withInput($request->only('name', 'email', 'subject', 'message'))
                ->withErrors(['email' => 'Der er sendt for mange beskeder på kort tid. Prøv igen senere.']);
        }

        $spamReasons = $this->spamReasons($request, $validated);

        if ($spamReasons !== []) {
            $this->logRejectedSubmission($request, $validated, $spamReasons);

            return redirect()->route('contact')->with('success', self::SUCCESS_MESSAGE);
        }

        foreach ($rateLimitKeys as $key) {
            RateLimiter::hit($key, 3600);
        }

        $settings = SiteSettings::current();
        $locale = app()->getLocale();

        $inquiry = ContactInquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'assigned_to' => $settings->default_inquiry_assignee_id,
            'locale' => $locale,
        ]);

        // Send confirmation to the person who submitted the inquiry
        try {
            Mail::to($inquiry->email)->send(new ContactInquiryConfirmation($inquiry, $locale));
        } catch (\Exception $e) {
            logger()->error('ContactInquiry confirmation mail failed: '.$e->getMessage());
        }

        // Notify the assigned user (or fallback to contact email)
        try {
            $assignee = $settings->defaultAssignee;
            $notifyEmail = $assignee?->email ?? $settings->contact_email;
            $assigneeLocale = $assignee?->locale ?? 'da';

            if ($notifyEmail) {
                Mail::to($notifyEmail)->send(new ContactInquiryNotification($inquiry, $assigneeLocale));
            }
        } catch (\Exception $e) {
            logger()->error('ContactInquiry notification mail failed: '.$e->getMessage());
        }

        return redirect()->route('contact')
            ->with('success', self::SUCCESS_MESSAGE);
    }

    private function tooManySubmissions(array $rateLimitKeys): bool
    {
        foreach ($rateLimitKeys as $key) {
            if (RateLimiter::tooManyAttempts($key, 3)) {
                return true;
            }
        }

        return false;
    }

    private function rateLimitKeys(Request $request, string $email): array
    {
        $emailKey = str($email)->lower()->trim()->toString();

        return [
            'contact-form:ip:'.sha1((string) $request->ip()),
            'contact-form:email:'.sha1($emailKey),
        ];
    }

    private function spamReasons(Request $request, array $validated): array
    {
        $reasons = [];
        $message = $validated['message'];
        $combined = strtolower(implode(' ', [
            $validated['name'],
            $validated['email'],
            $validated['subject'],
            $message,
        ]));

        if (! empty($validated['website'])) {
            $reasons[] = 'honeypot';
        }

        if ($request->filled('terms')) {
            $reasons[] = 'hidden_terms_field';
        }

        $startedAt = (int) ($validated['form_started_at'] ?? 0);
        if ($startedAt <= 0 || now()->timestamp - $startedAt < 3) {
            $reasons[] = 'too_fast';
        }

        if (preg_match_all('/https?:\/\/|www\.|\b[a-z0-9.-]+\.(?:ru|cn|top|xyz|click|monster|buzz|cam|party|loan|work)\b/i', $message) >= 3) {
            $reasons[] = 'link_stuffing';
        }

        if (preg_match('/(.)\1{12,}/u', $message) || preg_match('/\b([a-z]{3,})\b(?:\s+\1){4,}/iu', $message)) {
            $reasons[] = 'repeated_text';
        }

        $spamTerms = [
            'casino',
            'crypto',
            'forex',
            'loan',
            'payday',
            'seo backlink',
            'telegram',
            'viagra',
            'whatsapp',
        ];

        foreach ($spamTerms as $term) {
            if (str_contains($combined, $term)) {
                $reasons[] = 'spam_keyword';
                break;
            }
        }

        return array_values(array_unique($reasons));
    }

    private function logRejectedSubmission(Request $request, array $validated, array $reasons): void
    {
        logger()->warning('Rejected contact form spam submission', [
            'reasons' => $reasons,
            'ip_hash' => sha1((string) $request->ip()),
            'user_agent' => str((string) $request->userAgent())->limit(180)->toString(),
            'email_hash' => sha1(strtolower(trim($validated['email']))),
            'email_domain' => str($validated['email'])->after('@')->lower()->toString(),
            'subject_fingerprint' => sha1($validated['subject']),
            'message_fingerprint' => sha1($validated['message']),
        ]);
    }
}
