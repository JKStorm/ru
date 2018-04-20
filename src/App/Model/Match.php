<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'match';
    protected $fillable = ['id', 'length', 'date', 'completed', 'season', 'sport', 'competition', 'teams'];

    public function data()
    {
        return $this->hasMany(MatchData::class);
    }

    public function getDataPoint($type)
    {
        if (!in_array($type, MatchData::$types)) {
            throw new \InvalidArgumentException('Given $type not a valid type');
        }

        return $this->data()->where('type', $type)->first()->value;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function goals()
    {
        return $this->events()->where('type', Event::TYPE_GOAL);
    }

    public function getTopScorer()
    {
        $stack = [];

        foreach ($this->goals()->get() as $goal) {
            $stack[$goal->player_id]++;
        }

        if (count($stack) < 1) {
            return null;
        }

        arsort($stack);

        // Ascertain if the top spot is tied
        if (count($stack) >= 2) {
            $as = array_slice($stack, 0, 2);

            if ($as[0] === $as[1]) {
                return null;
            }
        }

        $topScorer = Player::find(array_shift($stack));

        return $topScorer->reference;
    }

    public function getWinner()
    {
        return ['Home', 'Away'][rand(0, 1)]; // I am not sure how a winner is determined from the XML, so I have mocked this.
    }
}
