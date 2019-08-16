<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $code;
    protected $toLead;

    public function __construct($user, $code)
    {
        $this->user     =   $user;
        $this->code     =   $code;
    }

    public function build()
    {
        $user   =   $this->user;
        $code   =   $this->code;

        $message    =   $this->view('mail.training.code', compact('user', 'code'));
        $message->subject(" Kode Verifikasi ");

        return $message;
    }
}