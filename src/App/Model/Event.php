<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const TYPE_GOAL = 1;
    const TYPE_BOOKING = 2;
    const ORIGINATOR_HOME = 1;
    const ORIGINATOR_AWAY = 2;

    protected $table = 'event';
    protected $fillable = ['type', 'player_id'];

    public function assists()
    {
        $this->hasMany(Assist::class);
    }

    public function match()
    {
        $this->hasOne(Match::class);
    }

    public function player()
    {
        $this->hasOne(Player::class);
    }

    public function assist()
    {
        $this->hasMany(Assist::class);
    }
}
