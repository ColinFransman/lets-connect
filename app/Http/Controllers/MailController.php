<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $additionalData;

    /**
     * Create a new message instance.
     */
    public function __construct($subject = "Default Subject", $body = "Default email body", $additionalData = [])
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->additionalData = $additionalData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emailstemplate')  // View for the email body
                    ->with(array_merge(
                        ['body' => $this->body],
                        $this->additionalData
                    ));  // Data passed to the view
    }
}