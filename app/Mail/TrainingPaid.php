<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrainingPaid extends Mailable
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
        if ($user->lang == 'id') {
            $message = $this->view('mail.training.paid', compact('user', 'download'));
        } else {
            $message = $this->view('mail.training.paid-en', compact('user', 'download'));
        }

        /*$message    = $message
            ->attach($user->pdf_link, [
                'as'    => "qr-code-" . $user->invoice,
                'mime'  => 'application/pdf',
            ]);*/
        if ($user->lang == 'id') {
            $message->subject("Pembayaran Seminar sukses | Importir.org ");
        } else {
            $message->subject("Success Seminar Payment | Importir.org ");
        }
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
