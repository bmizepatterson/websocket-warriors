<?php

namespace App\Http\Controllers;

use App\User;
use App\Game;
use App\Message;
use App\Events\NewMessage;
use App\Events\UserTyping;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Post a new message
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Game $game)
    {
        \Log::debug($request);
        $user = User::findOrFail($request->user['id']);
        $message = new Message([
            'text' => $request->message,
        ]);
        $message->game()->associate($game);
        $message->user()->associate($user);
        $message->save();
        broadcast(new NewMessage($message))->toOthers();
        return $game->fresh()->messages;
    }

    /**
     * Get the messages for a particular game
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function getMessages(Request $request, Game $game)
    {
        return $game->messages;
    }
}
