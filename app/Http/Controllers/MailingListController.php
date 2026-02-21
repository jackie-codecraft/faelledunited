<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MailingListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $already = NewsletterSubscriber::where('email', $request->email)->exists();

        if (! $already) {
            NewsletterSubscriber::create([
                'email'        => $request->email,
                'locale'       => app()->getLocale(),
                'confirmed'    => true,
                'confirmed_at' => now(),
                'token'        => Str::random(32),
            ]);
        }

        return back()->with('mailing_success', true);
    }
}
