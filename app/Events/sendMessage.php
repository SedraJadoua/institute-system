<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class sendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    protected $message;
    protected $groupId;
    /**
     * Create a new event instance.
     */
    public function __construct(string $message ,string $groupId)
    {
        $this->message = $message;
        $this->groupId = $groupId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat'.$this->groupId),
        ];
    }
    
    public function broadcastWith()
    {
        return [
            'user' => auth()->guard('student')->user() ? auth()->guard('student')->user() : auth()->guard('teacher')->user(),
            'message' => $this->message,
        ];
    }
}
