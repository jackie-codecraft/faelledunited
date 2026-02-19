<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;

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

        ContactInquiry::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Tak for din besked! Vi vender tilbage til dig hurtigst muligt.');
    }
}
