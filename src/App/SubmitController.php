<?php

namespace App;

use App\Model\Event;
use App\Model\Player;
use App\Parser\Submit as SubmitParser;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Match;
use App\Model\MatchData;

class SubmitController
{
    public function index(Request $request, Response $response)
    {
        $body = $request->getAttribute('parsedBody');

        $match = Match::find($body['id']);

        if (!$match) {
            $match = new Match();
        }

        $match->fill($body);

        /**
         * @todo Fetch this from the remote URL given in param `feed_file` using a queue and HTTP client
         * @see README.md
         */
        $xmlMatchData = file_get_contents(__DIR__ . '/../../public/data/fake_xml_match_data.xml');

        $xmlObj = new \DOMDocument();
        $xmlObj->loadXML($xmlMatchData);

        $parserResult = (new SubmitParser())->run($xmlObj);

        $match->date = $parserResult['matchDate'];
        $match->red_cards = $parserResult['redCards'];
        $match->yellow_cards = $parserResult['yellowCards'];
        $match->length = random_int(1, 100); // I couldn't actually see where this would be calculated in the sample XML
        $match->completed = rand(0, 1); // Again, not entirely sure how we determine if a match is complete

        $match->saveOrFail();

        $this->processGoals($parserResult['goals']['Home'], $match, Event::ORIGINATOR_HOME);
        $this->processGoals($parserResult['goals']['Away'], $match, Event::ORIGINATOR_AWAY);

        $this->processMatchData($parserResult['tackles']['Home'], $match, MatchData::TYPE_HOME_TACKLES);
        $this->processMatchData($parserResult['tackles']['Away'], $match, MatchData::TYPE_AWAY_TACKLES);
        $this->processMatchData($parserResult['touches']['Home'], $match, MatchData::TYPE_HOME_TOUCHES);
        $this->processMatchData($parserResult['touches']['Away'], $match, MatchData::TYPE_AWAY_TOUCHES);
        $this->processMatchData($parserResult['fouls']['Home'], $match, MatchData::TYPE_HOME_FOULS);
        $this->processMatchData($parserResult['fouls']['Away'], $match, MatchData::TYPE_AWAY_FOULS);

        return $response->withJson([
            'success' => true
        ]);
    }

    private function processGoals($goals, Match $match, $originatorId)
    {
        foreach ($goals as $goal) {
            $player = Player::where('reference', $goal['player_ref'])->first();

            if (!$player) {
                $player = new Player();
                $player->reference = $goal['player_ref'];
                $player->save();
            }
        }

        $playerRefs = array_map(function($goal) {
            return $goal['player_ref'];
        }, $goals);

        $playersKVP = Player::whereIn('reference', $playerRefs)->pluck('id', 'reference');

        foreach ($goals as $goal) {
            $event = Event::find($goal['id']);

            if (!$event) {
                $event = new Event();

                $event->id = $goal['id'];
                $event->type = Event::TYPE_GOAL;
                $event->match_id = $match->id;
                $event->player_id = $playersKVP[$goal['player_ref']];
                $event->originator_id = $originatorId;
                $event->save();
            }
        }
    }

    private function processMatchData($count, Match $match, $type)
    {
        $homeTackles = MatchData::where([
            'match_id' => $match->id,
            'type' => $type,
        ])->first();

        if (!$homeTackles) {
            $homeTackles = new MatchData();
            $homeTackles->match_id = $match->id;
            $homeTackles->type = $type;
        }

        $homeTackles->value = $count;
        $homeTackles->save();
    }
}
