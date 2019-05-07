<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public static function makeCode()
    {
        $faker = \Faker\Factory::create();
        $code = strtolower(implode('-', [
            $faker->safeColorName,
            $faker->firstName,
            'in',
            $faker->monthName,
            $faker->year,
        ]));
        return Game::whereCode($code)->count() ? static::makeCode() : $code;
    }
}
