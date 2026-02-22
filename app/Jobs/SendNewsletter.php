<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public readonly Newsletter $newsletter,
    ) {}

    public function handle(): void
    {
        // Mark as sending
        $this->newsletter->status = 'sending';
        $this->newsletter->save();

        // Determine recipients
        if ($this->newsletter->recipient_type === 'all') {
            $recipients = NewsletterSubscriber::where('confirmed', true)->get();
        } else {
            $ids = $this->newsletter->recipient_ids ?? [];
            $recipients = NewsletterSubscriber::whereIn('id', $ids)->get();
        }

        $totalSent = 0;

        // Send in chunks to avoid memory issues
        foreach ($recipients->chunk(100) as $chunk) {
            foreach ($chunk as $subscriber) {
                try {
                    Mail::to($subscriber->email)->send(new NewsletterMail(
                        newsletter: $this->newsletter,
                        recipientName: $subscriber->email,
                        recipientEmail: $subscriber->email,
                        locale: $subscriber->locale ?? 'da',
                    ));
                    $totalSent++;
                } catch (\Throwable $e) {
                    // Log and continue — don't let one bad address kill the batch
                    \Illuminate\Support\Facades\Log::warning('Newsletter send failed for ' . $subscriber->email, [
                        'newsletter_id' => $this->newsletter->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        // Mark as sent
        $this->newsletter->status     = 'sent';
        $this->newsletter->sent_at    = now();
        $this->newsletter->total_sent = $totalSent;
        $this->newsletter->save();
    }
}
