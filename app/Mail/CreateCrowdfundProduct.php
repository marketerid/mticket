<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateCrowdfundProduct extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function build()
    {
        $message  = $this->view('mail.crowdfund.create-product')
            ->subject("Informasi Crowdfund Terbaru | Importir.org");

        return $message;
    }
}