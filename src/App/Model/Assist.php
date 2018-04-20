<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Assist extends Model
{
    protected $table = 'event_assist';

    public function player()
    {
        return $this->hasOne(Player::class);
    }
}
