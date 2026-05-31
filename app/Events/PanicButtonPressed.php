<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PanicButtonPressed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $workArea;
    public $time;

    /**
     * Create a new event instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->workArea = $user->workArea;
        $this->time = now();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('emergency-alerts'),
        ];
    }
}
