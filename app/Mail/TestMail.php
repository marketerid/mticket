<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $demo;
    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sender@example.com')
        ->view('mail.demo')
        ->text('mail.demo_plain')
        ->with(
          [
                'testVarOne' => '1',
                'testVarTwo' => '2',
          ])
          ->attach(public_path('/images').'/demo.jpg', [
                  'as' => 'demo.jpg',
                  'mime' => 'image/jpeg',
          ]);
    }
}
