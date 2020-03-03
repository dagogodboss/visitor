<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Request;

class VisitorListExcel extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $attachment;

    /**
     * Create a new message instance.
     *
     * @param $request
     * @param $attachment
     */
    public function __construct($request, $attachment)
    {
        $this->request    = $request;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(setting('site_email'))
            ->attach($this->attachment)
            ->markdown('admin.mails.visitor.visitor-list-excel');
    }
}
