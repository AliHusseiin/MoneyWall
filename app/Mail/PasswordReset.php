<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    public $URL;
    public $userFirstName;
    public $userLastName;
    /**
     * Create a new message instance.
     */
    public function __construct($URL, $userFirstName, $userLastName)
    {
        //
        $this->URL = $URL;
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
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
        return $this->view('reset.password-reset')
                ->subject('Reset Your Password')
                ->with([
                    'URL' => $this->URL,
                    'fname' => $this->userFirstName,
                    'lname' => $this->userLastName,
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
