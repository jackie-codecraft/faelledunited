<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Response;

class NewsletterPreviewController extends Controller
{
    public function show(Newsletter $newsletter): Response
    {
        return response()->view('emails.newsletter-preview', [
            'newsletter' => $newsletter,
        ]);
    }
}
