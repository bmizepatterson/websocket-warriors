<?php

namespace App\Http\Controllers;

use App\Game;
use App\User;
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

        $user = new User;
        $user->name = $request->name;
        $user->score = $request->score;
        $game->users()->save($user);

        return $game->fresh();
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
        return Game::whereCode($gameCode)->firstOrFail();
    }

    /**
     * Process a play
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  string $gameCode
     * @return \Illuminate\Http\Response
     */
    public function play(Request $request, $gameCode)
    {
        event(new UserScoreUpdated(
            Game::whereCode($gameCode)->firstOrFail(),
            $request->user,
            $request->score,
        ));
    }
}
