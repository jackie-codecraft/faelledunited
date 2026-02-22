<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    /**
     * Show the unsubscribe confirmation page.
     * GET /afmeld?token=xxx
     */
    public function confirm(Request $request)
    {
        $token = $request->query('token');
        $subscriber = $token
            ? NewsletterSubscriber::where('token', $token)->first()
            : null;

        return view('unsubscribe.confirm', compact('subscriber', 'token'));
    }

    /**
     * Process the unsubscribe.
     * POST /afmeld
     */
    public function process(Request $request)
    {
        $token = $request->input('token');
        $subscriber = $token
            ? NewsletterSubscriber::where('token', $token)->first()
            : null;

        if ($subscriber) {
            $subscriber->delete();
        }

        return view('unsubscribe.done');
    }
}
