<?php

namespace App\Events;

use App\User;
use App\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $typing;
    public $userId;
    public $gameId;

    /**
     * Create a new event instance.
     *
     * @param  \App\User $user
     * @param  \App\Game $game
     * @param  boolean   $typing
     * @return void
     */
    public function __construct($userId, $gameId, $typing)
    {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->typing = $typing;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('game.'.$this->gameId);
    }
}
