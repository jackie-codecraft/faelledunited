<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryConfirmation;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required'    => 'Navn er påkrævet.',
            'email.required'   => 'E-mail er påkrævet.',
            'email.email'      => 'Angiv en gyldig e-mailadresse.',
            'subject.required' => 'Emne er påkrævet.',
            'message.required' => 'Besked er påkrævet.',
        ]);

        $inquiry = ContactInquiry::create($validated);

        try {
            Mail::to($inquiry->email)->send(new ContactInquiryConfirmation($inquiry, app()->getLocale()));
        } catch (\Exception $e) {
            // Mail failure should not block the user — log silently
            logger()->error('ContactInquiry confirmation mail failed: ' . $e->getMessage());
        }

        return redirect()->route('contact')
            ->with('success', 'Tak for din besked! Vi vender tilbage til dig hurtigst muligt.');
    }
}
