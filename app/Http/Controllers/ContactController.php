<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryConfirmation;
use App\Mail\ContactInquiryNotification;
use App\Models\ContactInquiry;
use App\Models\SiteSettings;
use App\Support\SpamProtection\PublicFormSpamProtection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    use PublicFormSpamProtection;

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
            ...$this->spamProtectionValidationRules(),
        ], [
            'name.required' => 'Navn er påkrævet.',
            'email.required' => 'E-mail er påkrævet.',
            'email.email' => 'Angiv en gyldig e-mailadresse.',
            'subject.required' => 'Emne er påkrævet.',
            'message.required' => 'Besked er påkrævet.',
            'message.min' => 'Beskeden skal være mindst 10 tegn.',
        ]);

        $rateLimitKeys = $this->publicFormRateLimitKeys($request, 'contact-form', [
            'email' => $validated['email'],
        ]);

        if ($this->tooManyPublicFormSubmissions($rateLimitKeys)) {
            return back()
                ->withInput($request->only('name', 'email', 'subject', 'message'))
                ->withErrors(['email' => 'Der er sendt for mange beskeder på kort tid. Prøv igen senere.']);
        }

        $contentFields = $request->only('name', 'email', 'subject', 'message');
        $spamReasons = $this->publicFormSpamReasons($request, $contentFields);

        if ($spamReasons !== []) {
            $this->logRejectedPublicFormSubmission($request, 'contact', $contentFields, $spamReasons);

            return redirect()->route('contact')->with('success', self::SUCCESS_MESSAGE);
        }

        $this->hitPublicFormRateLimits($rateLimitKeys);

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
}
