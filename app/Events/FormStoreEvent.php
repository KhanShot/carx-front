<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormStoreEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $form;
    private $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($form, $userId)
    {
        //
        $this->form = $form;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('form-store.' . $this->userId),
            new Channel('form-store.' . 1), //send also to admin
        ];
    }

    public function broadcastAs()
    {
        return 'form-store_event';
    }

    public function broadcastWith()
    {
        return [
            'form' => $this->form
        ];
    }
}
