<?php

namespace App\Events;

use App\Game;
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
    public $score;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Game $game, $user, $score)
    {
        $this->game = $game;
        $this->user = $user;
        $this->score = $score;

        \Log::debug('New UserScoreUpdated:', [
            'channel' => 'game.'.$this->game->getKey(),
            'game' => $game->code,
            'user' => $user,
            'score' => $score
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
