<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmPaymentFees extends Mailable
{
    use Queueable, SerializesModels;

    protected $shipping;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $shipping = $this->shipping;
        $message  = $this->view('mail.shipping.confirm-payment-fees',compact('shipping'));
        
        return $message;
    }
}
