<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberRegister extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $member;
    protected $disc;

    public function __construct($member, $disc)
    {
        $this->member       = $member;
        $this->disc         = $disc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $member   = $this->member;
        $disc     = $this->disc;

        return $this->view('mail.member.register', compact('member', 'disc'));
    }
}
