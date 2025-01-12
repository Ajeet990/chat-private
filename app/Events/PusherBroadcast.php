<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $message;
    public int $senderId;
    public int $receiverId;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, int $senderId, int $receiverId)
    {
        $this->message = $message;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
    }

    // public function __construct(string $message)
    // {
    //     $this->message = $message;
    // }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // return [
        //     new PrivateChannel('channel-name'),
        // ];
        // return [new PrivateChannel('chat.' . $this->senderId . '_' . $this->receiverId)];
        // return [new PrivateChannel('chat.123')];
        return ['chat.123'];
    }

    // public function broadcastOn(): array
    // {
    //     return [new PrivateChannel('chat.' . $this->senderId . '.' . $this->receiverId)];
    // }

    // public function broadcastOn(): array
    // {
    //     return [new Channel('chat.' . $this->receiverId)];
    // }


    public function broadcastAs(): string
    {
        return 'chat';
    }
}
