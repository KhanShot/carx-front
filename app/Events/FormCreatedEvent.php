<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $user, $row;
    public function __construct($row, $user)
    {
        $this->user = $user;
        $this->row = $row;
    }
    public function broadcastWith()
    {
        return [
            'row' => $this->row,
            'user' => $this->user,
            'test' => true,
        ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return
     */
    public function broadcastOn()
    {
        return new PrivateChannel('form-created.' . $this->user->id);
    }
    public function broadcastAs()
    {
        return 'event-form_created';
    }
}

