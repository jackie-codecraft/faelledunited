<?php

namespace Tests\Feature;

use App\Models\AgeGroup;
use App\Models\Department;
use App\Models\SiteSettings;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RegistrationSpamProtectionTest extends TestCase
{
    use RefreshDatabase;

    private Department $department;

    private AgeGroup $ageGroup;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
        Mail::fake();
        SiteSettings::current();

        $this->department = Department::create([
            'slug' => 'football',
            'name_da' => 'Fodbold',
            'name_en' => 'Football',
            'is_active' => true,
        ]);

        $this->ageGroup = AgeGroup::create([
            'department_id' => $this->department->id,
            'slug' => 'u10',
            'label_da' => 'U10',
            'label_en' => 'U10',
            'gender' => 'mixed',
            'is_active' => true,
        ]);

        RateLimiter::clear('registration-form:ip:'.sha1('127.0.0.1'));
        RateLimiter::clear('registration-form:email:'.sha1('parent@example.com'));
        RateLimiter::clear('registration-form:phone:'.sha1('12345678'));
    }

    public function test_valid_registration_submission_creates_registration(): void
    {
        $response = $this->post(route('registration.store'), $this->validPayload());

        $response->assertRedirect(route('registration.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('registrations', [
            'player_name' => 'Emma Hansen',
            'parent_email' => 'parent@example.com',
        ]);
    }

    public function test_honeypot_registration_submission_is_silently_rejected(): void
    {
        $response = $this->post(route('registration.store'), $this->validPayload([
            'website' => 'https://spam.example',
        ]));

        $response->assertRedirect(route('registration.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('registrations', 0);
    }

    public function test_too_fast_registration_submission_is_silently_rejected(): void
    {
        $response = $this->post(route('registration.store'), $this->validPayload([
            'form_started_at' => now()->timestamp,
        ]));

        $response->assertRedirect(route('registration.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('registrations', 0);
    }

    public function test_registration_submissions_are_rate_limited(): void
    {
        foreach (range(1, 3) as $attempt) {
            $this->post(route('registration.store'), $this->validPayload([
                'player_name' => 'Emma Hansen '.$attempt,
                'parent_email' => "parent{$attempt}@example.com",
                'phone' => '1234567'.$attempt,
            ]))->assertRedirect(route('registration.create'));
        }

        $response = $this->from(route('registration.create'))->post(route('registration.store'), $this->validPayload([
            'player_name' => 'Emma Hansen 4',
            'parent_email' => 'parent4@example.com',
            'phone' => '12345674',
        ]));

        $response->assertRedirect(route('registration.create'));
        $response->assertSessionHasErrors('parent_email');
        $this->assertDatabaseCount('registrations', 3);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'player_name' => 'Emma Hansen',
            'date_of_birth' => now()->subYears(10)->toDateString(),
            'department_id' => $this->department->id,
            'age_group_id' => $this->ageGroup->id,
            'current_club_experience' => 'New player',
            'parent_name' => 'Mads Hansen',
            'parent_email' => 'parent@example.com',
            'phone' => '12345678',
            'address' => 'Ørestads Boulevard 55, 2300 København S',
            'additional_info' => 'Please let us know when training starts.',
            'gdpr_consent' => '1',
            'photo_consent' => '1',
            'form_started_at' => now()->subSeconds(10)->timestamp,
            'website' => '',
        ], $overrides);
    }
}
