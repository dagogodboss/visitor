<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitorCheckInEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The visitor instance
     *
     * @var $visitor
     */
    public $visitor;

    /**
     * Create a new message instance.
     *
     * @param $visitor
     */
    public function __construct($visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(setting('site_email'))
            ->view('admin.mails.visitor.checked-in')
            ->text('admin.mails.visitor.checked-in-plain');
    }
}
