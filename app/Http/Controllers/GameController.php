<?php

namespace App\Http\Controllers;

use App\Game;
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
        return $game->code;
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
     * @param  \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request, Game $game)
    {
        return;
    }
}
