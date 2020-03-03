<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\User;

class SendSmsVisitorHost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $settings;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
