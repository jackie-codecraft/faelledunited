<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryReply;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ContactInquiryReplyController extends Controller
{
    /**
     * Show the reply form for a given contact inquiry.
     */
    public function show(Request $request, ContactInquiry $inquiry)
    {
        return view('contact.reply', [
            'inquiry' => $inquiry,
        ]);
    }

    /**
     * Send the reply and mark the inquiry as replied.
     */
    public function send(Request $request, ContactInquiry $inquiry)
    {
        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'max:5000'],
        ]);

        // Send reply email to the original submitter
        Mail::to($inquiry->email)->send(
            new ContactInquiryReply($inquiry, $validated['reply_message'])
        );

        // Mark the inquiry as replied
        $inquiry->status = 'replied';
        $inquiry->save();

        // Redirect back to the signed GET route with a success flash
        return redirect(URL::signedRoute('contact.inquiry.reply', ['inquiry' => $inquiry->id]))
            ->with('success', true);
    }
}
