<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ContactSpamProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);

        Mail::fake();
        RateLimiter::clear('contact-form:ip:'.sha1('127.0.0.1'));
        RateLimiter::clear('contact-form:email:'.sha1('parent@example.com'));
    }

    public function test_valid_contact_submission_creates_inquiry(): void
    {
        $response = $this->post(route('contact.store'), $this->validPayload());

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Parent Name',
            'email' => 'parent@example.com',
            'subject' => 'Training question',
        ]);
    }

    public function test_honeypot_submission_is_silently_rejected(): void
    {
        $response = $this->post(route('contact.store'), $this->validPayload([
            'website' => 'https://spam.example',
        ]));

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    public function test_too_fast_submission_is_silently_rejected(): void
    {
        $response = $this->post(route('contact.store'), $this->validPayload([
            'form_started_at' => now()->timestamp,
        ]));

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    public function test_contact_submissions_are_rate_limited_by_ip_and_email(): void
    {
        foreach (range(1, 3) as $attempt) {
            $this->post(route('contact.store'), $this->validPayload([
                'subject' => 'Training question '.$attempt,
            ]))->assertRedirect(route('contact'));
        }

        $response = $this->from(route('contact'))->post(route('contact.store'), $this->validPayload([
            'subject' => 'Training question 4',
        ]));

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('contact_inquiries', 3);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Parent Name',
            'email' => 'parent@example.com',
            'subject' => 'Training question',
            'message' => 'Hello, I would like to ask about youth football training options.',
            'form_started_at' => now()->subSeconds(10)->timestamp,
            'website' => '',
        ], $overrides);
    }
}
