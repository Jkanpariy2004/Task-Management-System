<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $recipientEmail; // Add a property to hold the recipient's email
    protected $passwordCreationUrl; // Add a property for the password creation URL

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $recipientEmail, string $passwordCreationUrl)
    {
        $this->recipientEmail = $recipientEmail;
        $this->passwordCreationUrl = $passwordCreationUrl; // Store the password creation URL
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Invitation Mail',
            to: [$this->recipientEmail], // Set the recipient's email
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'Dashboard.Emails.AdminInvitation',
            with: [
                'passwordCreationUrl' => $this->passwordCreationUrl, // Pass the URL to the view
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
