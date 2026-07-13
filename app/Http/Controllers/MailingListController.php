<?php

namespace App\Http\Controllers;

use App\Mail\MailingListWelcome;
use App\Models\NewsletterSubscriber;
use App\Support\SpamProtection\PublicFormSpamProtection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailingListController extends Controller
{
    use PublicFormSpamProtection;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
            ...$this->spamProtectionValidationRules(),
        ]);

        $rateLimitKeys = $this->publicFormRateLimitKeys($request, 'mailing-list', [
            'email' => $validated['email'],
        ]);

        if ($this->tooManyPublicFormSubmissions($rateLimitKeys)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Der er sendt for mange tilmeldinger på kort tid. Prøv igen senere.']);
        }

        $contentFields = $request->only('email');
        $spamReasons = $this->publicFormSpamReasons($request, $contentFields);

        if ($spamReasons !== []) {
            $this->logRejectedPublicFormSubmission($request, 'mailing-list', $contentFields, $spamReasons);

            return back()->with('mailing_success', true);
        }

        $this->hitPublicFormRateLimits($rateLimitKeys);

        $already = NewsletterSubscriber::where('email', $validated['email'])->exists();

        if (! $already) {
            $subscriber = NewsletterSubscriber::create([
                'email' => $validated['email'],
                'locale' => app()->getLocale(),
                'confirmed' => true,
                'confirmed_at' => now(),
                'token' => Str::random(32),
            ]);

            try {
                Mail::to($subscriber->email)->send(new MailingListWelcome($subscriber, app()->getLocale()));
            } catch (\Exception $e) {
                logger()->error('MailingList welcome mail failed: '.$e->getMessage());
            }
        }

        return back()->with('mailing_success', true);
    }
}
