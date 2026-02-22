<?php

namespace App\Http\Controllers;

use App\Mail\MailingListWelcome;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            $subscriber = NewsletterSubscriber::create([
                'email'        => $request->email,
                'locale'       => app()->getLocale(),
                'confirmed'    => true,
                'confirmed_at' => now(),
                'token'        => Str::random(32),
            ]);

            try {
                Mail::to($subscriber->email)->send(new MailingListWelcome($subscriber));
            } catch (\Exception $e) {
                logger()->error('MailingList welcome mail failed: ' . $e->getMessage());
            }
        }

        return back()->with('mailing_success', true);
    }
}
