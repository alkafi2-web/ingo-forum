<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        // You can pass data to the email here if needed
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('test@ingo.webase.info') // Ensure this is a valid sender
                    ->subject('Welcome to INGO Forum Newsletter')
                    ->view('mail.newsletter_subscription'); // Ensure this view exists
    }
}
