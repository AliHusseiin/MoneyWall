<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    public $URL;
    /**
     * Create a new message instance.
     */
    public function __construct($URL)
    {
        //
        $this->URL = $URL;
    }

    /**
     * Get the message envelope.
     */

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // view: 'view.name',
        );
    }
    public function build()
    {
        return $this->view('email.EmailVerification')
                ->subject('Verify Your Email')
                ->with([
                    'URL' => $this->URL,
                ]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
