<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentCrowdfund extends Mailable
{
    use Queueable, SerializesModels;

    protected $cfOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cfOrder)
    {
        $this->cfOrder = $cfOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cfOrder = $this->cfOrder;
        $message  = $this->view('mail.crowdfund.payment',compact('cfOrder'))
            ->subject("Tagihan order product Importir.net");

        return $message;
    }
}
