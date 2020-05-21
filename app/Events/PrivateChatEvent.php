<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $targetUserId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $targetUserId)
    {
        $this->targetUserId = $targetUserId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $authUserId = Auth::user()->id;
        $pairIdArr = array($authUserId, $this->targetUserId);
        sort($pairIdArr);
        $pairIdDraft = implode(".", $pairIdArr);
        return new PrivateChannel('privateChat.' . $pairIdDraft);
        //return new PrivateChannel('privateChat.1.2');
    }

    public function broadcastWith()
    {
        return ['PRIVATE'];
    }
}
