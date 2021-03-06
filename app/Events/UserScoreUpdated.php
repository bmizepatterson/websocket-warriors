<?php

namespace App\Events;

use App\Game;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UserScoreUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Game $game, User $user)
    {
        $this->game = $game;
        $this->user = $user;

        \Log::debug('New UserScoreUpdated:', [
            'channel' => 'game.'.$this->game->getKey(),
            'game' => $game->code,
            'user' => $user->name,
            'score' => $user->score,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('game.'.$this->game->getKey());
    }
}
