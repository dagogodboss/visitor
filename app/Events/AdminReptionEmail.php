<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AdminReptionEmail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $settings;
    public $pre_register;

    public function __construct($user, $pre_register)
    {

        $this->user = $user;
        $this->pre_register = $pre_register;
    }
}
