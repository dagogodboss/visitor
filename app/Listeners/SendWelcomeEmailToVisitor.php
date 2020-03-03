<?php

namespace App\Listeners;

use App\Events\VisitorCheckedIn;
use App\Mail\VisitorCheckInEmail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToVisitor
{
    /**
     * Handle the event.
     *
     * @param  VisitorCheckedIn  $event
     */
    public function handle(VisitorCheckedIn $event)
    {
        //send the welcome email to the visitor
        $visitor = $event->visitor;
        Mail::to($visitor->email)->send(new VisitorCheckInEmail($visitor));
    }
}
