<?php

namespace App\Support\SpamProtection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

trait PublicFormSpamProtection
{
    protected function spamProtectionValidationRules(): array
    {
        return [
            'website' => ['nullable', 'string', 'max:255'],
            'form_started_at' => ['nullable', 'integer'],
            'terms' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function tooManyPublicFormSubmissions(array $rateLimitKeys, int $maxAttempts = 3): bool
    {
        foreach ($rateLimitKeys as $key) {
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                return true;
            }
        }

        return false;
    }

    protected function hitPublicFormRateLimits(array $rateLimitKeys, int $decaySeconds = 3600): void
    {
        foreach ($rateLimitKeys as $key) {
            RateLimiter::hit($key, $decaySeconds);
        }
    }

    protected function publicFormRateLimitKeys(Request $request, string $form, array $identifiers = []): array
    {
        $keys = [
            $form.':ip:'.sha1((string) $request->ip()),
        ];

        foreach ($identifiers as $name => $value) {
            $normalized = str((string) $value)->lower()->trim()->toString();

            if ($normalized !== '') {
                $keys[] = $form.':'.$name.':'.sha1($normalized);
            }
        }

        return $keys;
    }

    protected function publicFormSpamReasons(Request $request, array $contentFields, int $minimumSeconds = 3): array
    {
        $reasons = [];
        $combined = strtolower(implode(' ', array_filter(array_map('strval', $contentFields))));

        if ($request->filled('website')) {
            $reasons[] = 'honeypot';
        }

        if ($request->filled('terms')) {
            $reasons[] = 'hidden_terms_field';
        }

        $startedAt = (int) $request->input('form_started_at', 0);
        if ($startedAt <= 0 || now()->timestamp - $startedAt < $minimumSeconds) {
            $reasons[] = 'too_fast';
        }

        if (preg_match_all('/https?:\/\/|www\.|\b[a-z0-9.-]+\.(?:ru|cn|top|xyz|click|monster|buzz|cam|party|loan|work)\b/i', $combined) >= 3) {
            $reasons[] = 'link_stuffing';
        }

        if (preg_match('/(.)\1{12,}/u', $combined) || preg_match('/\b([a-z]{3,})\b(?:\s+\1){4,}/iu', $combined)) {
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

    protected function logRejectedPublicFormSubmission(Request $request, string $form, array $contentFields, array $reasons): void
    {
        $email = (string) ($contentFields['email'] ?? $contentFields['parent_email'] ?? '');
        $message = (string) ($contentFields['message'] ?? $contentFields['additional_info'] ?? implode(' ', $contentFields));

        logger()->warning('Rejected public form spam submission', [
            'form' => $form,
            'reasons' => $reasons,
            'ip_hash' => sha1((string) $request->ip()),
            'user_agent' => str((string) $request->userAgent())->limit(180)->toString(),
            'email_hash' => $email !== '' ? sha1(strtolower(trim($email))) : null,
            'email_domain' => str($email)->after('@')->lower()->toString(),
            'message_fingerprint' => sha1($message),
        ]);
    }
}
