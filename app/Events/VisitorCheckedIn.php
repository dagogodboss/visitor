<?php

namespace App\Events;

use App\Models\Visitor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class VisitorCheckedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $visitor;

    /**
     * Create a new event instance.
     *
     * @param visitor $visitor
     */
    public function __construct(visitor $visitor)
    {
        $this->visitor = $visitor;
    }
}
