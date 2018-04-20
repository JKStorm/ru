<?php

namespace App;

use App\Model\MatchData;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Match;

class APIController
{
    public function football(Request $request, Response $response, $args)
    {
        $matchID = (int) $args['matchID'];

        $match = Match::find($matchID);

        $data = [
            'competition' => $match->competition,
            'match_id' => $match->id,
            'season' => $match->season,
            'sport' => $match->sport,
            'teams' => json_decode($match->teams),
            'match_length' => (int) $match->length,
            'match_date' => $match->date,
            'created_at' => $match->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $match->updated_at->format('Y-m-d H:i:s'),
            'complete' => (bool) $match->completed,
            'stats' => [
                'top_scorer' => $match->getTopScorer(),
                'winner' => $match->getWinner(),
                'total_goals' => $match->goals()->count(),
                'red_cards' => $match->red_cards,
                'yellow_cards' => $match->yellow_cards,
                'home' => [
                    'total_tackles' => $match->getDataPoint(MatchData::TYPE_HOME_TACKLES),
                    'total_touches' => $match->getDataPoint(MatchData::TYPE_HOME_TOUCHES),
                    'total_fouls' => $match->getDataPoint(MatchData::TYPE_HOME_FOULS),
                ],
                'away' => [
                    'total_tackles' => $match->getDataPoint(MatchData::TYPE_AWAY_TACKLES),
                    'total_touches' => $match->getDataPoint(MatchData::TYPE_AWAY_TOUCHES),
                    'total_fouls' => $match->getDataPoint(MatchData::TYPE_AWAY_FOULS),
                ],
            ],
        ];

        return $response->withJson($data);
    }
}
