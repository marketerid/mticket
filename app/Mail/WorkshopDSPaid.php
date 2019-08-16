<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WorkshopDSPaid extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    public function __construct($user)
    {
        $this->user     = $user;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user   = $this->user;

        $download   = $this->generateTokenTiketLink($user);
        $message    =  $this->view('mail.training.paid-ds', compact('user','download'));

        $message    = $message
            ->attach($user->pdf_link, [
                'as'    => "qr-code-" . $user->invoice,
                'mime'  => 'application/pdf',
            ]);
        $message->subject("Pembayaran Workshop sukses | Importir.org ");
        return $message;
    }

    public function generateTokenTiketLink($register){
        if(!$register){
            return '';
        }

        $result = [
            'ip'            => $register->ip,
            'invoice'       => $register->invoice
        ];

        return url('tiket?token=' . encrypt(json_encode($result)));
    }
}
