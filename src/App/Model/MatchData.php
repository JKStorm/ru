<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MatchData extends Model
{
    const TYPE_HOME_TACKLES = 1;
    const TYPE_AWAY_TACKLES = 2;
    const TYPE_HOME_TOUCHES = 3;
    const TYPE_AWAY_TOUCHES = 4;
    const TYPE_HOME_FOULS = 5;
    const TYPE_AWAY_FOULS = 6;

    public static $types = [
        self::TYPE_HOME_TACKLES,
        self::TYPE_AWAY_TACKLES,
        self::TYPE_HOME_TOUCHES,
        self::TYPE_AWAY_TOUCHES,
        self::TYPE_HOME_FOULS,
        self::TYPE_AWAY_FOULS,
    ];

    protected $table = 'match_data';
    protected $fillable = ['type', 'match_id', 'value', 'team_type'];

    public function match()
    {
        $this->hasOne(Match::class);
    }
}
