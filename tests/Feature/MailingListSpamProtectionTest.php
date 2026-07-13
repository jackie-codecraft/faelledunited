<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class MailingListSpamProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
        Mail::fake();
        RateLimiter::clear('mailing-list:ip:'.sha1('127.0.0.1'));
        RateLimiter::clear('mailing-list:email:'.sha1('parent@example.com'));
    }

    public function test_valid_mailing_list_submission_creates_subscriber(): void
    {
        $response = $this->post(route('mailing-list.store'), $this->validPayload());

        $response->assertSessionHas('mailing_success');
        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'parent@example.com',
            'confirmed' => true,
        ]);
    }

    public function test_honeypot_mailing_list_submission_is_silently_rejected(): void
    {
        $response = $this->post(route('mailing-list.store'), $this->validPayload([
            'website' => 'https://spam.example',
        ]));

        $response->assertSessionHas('mailing_success');
        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_too_fast_mailing_list_submission_is_silently_rejected(): void
    {
        $response = $this->post(route('mailing-list.store'), $this->validPayload([
            'form_started_at' => now()->timestamp,
        ]));

        $response->assertSessionHas('mailing_success');
        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_mailing_list_submissions_are_rate_limited(): void
    {
        foreach (range(1, 3) as $attempt) {
            $this->post(route('mailing-list.store'), $this->validPayload([
                'email' => "parent{$attempt}@example.com",
            ]))->assertSessionHas('mailing_success');
        }

        $response = $this->from(route('contact'))->post(route('mailing-list.store'), $this->validPayload([
            'email' => 'parent4@example.com',
        ]));

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('newsletter_subscribers', 3);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'email' => 'parent@example.com',
            'form_started_at' => now()->subSeconds(10)->timestamp,
            'website' => '',
        ], $overrides);
    }
}
