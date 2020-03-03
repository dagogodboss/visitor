<?php

namespace App\Listeners;

use App\Events\AdminReptionEmail;
use App\Mail\AdminRecptionCheckInEmail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToAdminRecipteion
{

    public function handle(AdminReptionEmail $event)
    {
        //send the welcome email to the visitor
        $user = $event->user[0];
        $pre_register = $event->pre_register;
        Mail::to($user->email)->send(new AdminRecptionCheckInEmail($user,$pre_register));
    }
}
