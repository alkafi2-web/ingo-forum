<?php

namespace App\Mail;

use App\Models\Subsciber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subscriber;
    /**
     * Create a new message instance.
     */
    public function __construct(Subsciber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to INGO Forum Newsletter')
            ->view('mail.newsletter_subscription')
            ->with(['subscriber' => $this->subscriber]); // Pass the subscriber data to the view
    }
}
