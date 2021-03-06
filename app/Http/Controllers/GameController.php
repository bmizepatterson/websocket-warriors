<?php

namespace App\Http\Controllers;

use App\Game;
use App\User;
use App\Events\UserLeft;
use App\Events\UserJoined;
use App\Events\UserTyping;
use App\Events\UserScoreUpdated;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Save a game to the DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = new Game;
        $game->code = Game::makeCode();
        $game->save();
        return $game;
    }

    /**
     * Delete a game from the DB
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();
    }

    /**
     * Confirm that a game with the given code exists
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $gameCode
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request, $gameCode)
    {
        return Game::whereCode(strtolower($gameCode))->firstOrFail();
    }

    /**
     * Register a new user in this game
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, Game $game)
    {
        $user = new User;
        $user->name = $request->name;
        $user->score = $request->score;
        $game->users()->save($user);
        event(new UserJoined($game->fresh(), $user));
        return $game->users()->get();
    }

    /**
     * Remove a user from a game
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function leave(Request $request, Game $game)
    {
        \Log::debug($request);
        $user = User::findOrFail($request->user['id']);
        broadcast(new UserLeft($user, $game))->toOthers();
        $user->delete();
        if (!$game->fresh()->users()->count()) {
            $game->delete();
        }
    }

    /**
     * Process a play
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function play(Request $request, Game $game)
    {
        $user = User::findOrFail($request->id);
        $user->score = $request->score;
        $user->save();
        event(new UserScoreUpdated($game, $user->fresh()));
    }

    /**
     * Send a user-typing event
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function typing(Request $request, Game $game, User $user)
    {
        broadcast(new UserTyping($user->getKey(), $game->getKey(), true))->toOthers();
    }

    /**
     * Send a user-idle event
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Game $game
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function idle(Request $request, Game $game, User $user)
    {
        broadcast(new UserTyping($user->getKey(), $game->getKey(), false))->toOthers();
    }
}
