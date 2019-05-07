<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

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
