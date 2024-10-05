<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;
    public $sender_id;
    public $recipient_id;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->sender_id = $message->sender_id;
        $this->recipient_id = $message->recipient_id;
    }

    public function broadcastOn()
    {
        $sender_id = $this->sender_id;
        $recipient_id = $this->recipient_id;

        // Create a unique channel name that both users can subscribe to
        $channel_name = 'chat.' . min($sender_id, $recipient_id) . '.' . max($sender_id, $recipient_id);

        return new Channel($channel_name);
    }

    public function broadcastAs()
    {
        return 'message-sent';
    }
}
