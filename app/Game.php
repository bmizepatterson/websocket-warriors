<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * An array of players in this game
     * (not persisted to DB)
     * 
     * @var array
     */
    public $users;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['users'];

    /**
     * Get the users playing this game
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the messages in this game
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    /**
     * Generate a unique but memorable id code for this game
     */
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
