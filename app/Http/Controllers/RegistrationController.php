<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationConfirmation;
use App\Models\AgeGroup;
use App\Models\Department;
use App\Models\Registration;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function create()
    {
        $siteSettings = SiteSettings::current();
        $departments  = Department::where('is_active', true)->orderBy('sort_order')->get();
        $ageGroups    = AgeGroup::where('is_active', true)->orderBy('sort_order')->get();

        return view('registration.create', compact('siteSettings', 'departments', 'ageGroups'));
    }

    public function store(Request $request)
    {
        $settings = SiteSettings::current();

        if (! $settings->registration_open) {
            return redirect()->route('registration.create')
                ->with('registration_closed', true);
        }

        $validated = $request->validate([
            'player_name'             => ['required', 'string', 'max:255'],
            'date_of_birth'           => ['required', 'date', 'before:today'],
            'department_id'           => ['required', 'exists:departments,id'],
            'age_group_id'            => ['required', 'exists:age_groups,id'],
            'current_club_experience' => ['nullable', 'string', 'max:500'],
            'parent_name'             => ['required', 'string', 'max:255'],
            'parent_email'            => ['required', 'email', 'max:255'],
            'phone'                   => ['required', 'string', 'max:50'],
            'address'                 => ['required', 'string', 'max:500'],
            'additional_info'         => ['nullable', 'string', 'max:2000'],
            'gdpr_consent'            => ['accepted'],
            'photo_consent'           => ['nullable', 'boolean'],
        ], [
            'player_name.required'   => 'Barnets navn er påkrævet.',
            'date_of_birth.required' => 'Fødselsdato er påkrævet.',
            'date_of_birth.before'   => 'Fødselsdato skal være i fortiden.',
            'department_id.required' => 'Vælg en afdeling.',
            'age_group_id.required'  => 'Vælg en årgang.',
            'parent_name.required'   => 'Forælderens navn er påkrævet.',
            'parent_email.required'  => 'E-mail er påkrævet.',
            'parent_email.email'     => 'Angiv en gyldig e-mailadresse.',
            'phone.required'         => 'Telefonnummer er påkrævet.',
            'address.required'       => 'Adresse er påkrævet.',
            'gdpr_consent.accepted'  => __('reg.gdpr_consent_error'),
        ]);

        $registration = Registration::create([
            'player_name'             => $validated['player_name'],
            'date_of_birth'           => $validated['date_of_birth'],
            'department_id'           => $validated['department_id'],
            'age_group_id'            => $validated['age_group_id'],
            'current_club_experience' => $validated['current_club_experience'] ?? null,
            'parent_name'             => $validated['parent_name'],
            'parent_email'            => $validated['parent_email'],
            'phone'                   => $validated['phone'],
            'address'                 => $validated['address'],
            'additional_info'         => $validated['additional_info'] ?? null,
            'gdpr_consent'            => true,
            'photo_consent'           => $request->boolean('photo_consent'),
            'status'                  => 'new',
        ]);

        try {
            Mail::to($registration->parent_email)->send(new RegistrationConfirmation($registration, app()->getLocale()));
        } catch (\Exception $e) {
            logger()->error('Registration confirmation mail failed: ' . $e->getMessage());
        }

        return redirect()->route('registration.create')
            ->with('success', __('reg.success', [
                'name'  => $validated['player_name'],
                'email' => $validated['parent_email'],
            ]));
    }
}
