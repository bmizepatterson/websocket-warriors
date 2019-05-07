<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }
    /**
     * Save a game to the DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = new Game;
        $game->code = $faker->safeColorName;
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
}
