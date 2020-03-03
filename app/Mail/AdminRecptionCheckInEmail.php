<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRecptionCheckInEmail extends Mailable
{
    use Queueable, SerializesModels;



    public $user;
    public $pre_register;

    public function __construct($user, $pre_register)
    {

        $this->user = $user;
        $this->pre_register = $pre_register;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(setting('site_email'))
            ->view('admin.mails.adminrecption.Admin-Recption')
            ->text('admin.mails.adminrecption.Admin-Recption-plain');
    }
}
