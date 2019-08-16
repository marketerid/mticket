<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomRegister extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $contentMess;
    public function __construct($contentMess)
    {
        $this->contentMess         = $contentMess;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contentMess   = $this->contentMess;

        return $this->view('mail.custom.register', compact('contentMess'));
    }
}
