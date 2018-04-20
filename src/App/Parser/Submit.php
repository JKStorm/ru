<?php

namespace App\Parser;

class Submit implements ParserInterface
{
    public function run(\DOMDocument $xmlObj)
    {
        $matchDate = null;
        $goals = [];
        $tackles = [];
        $touches = [];
        $fouls = [];
        $redCards = 0;
        $yellowCards = 0;

        $matchDateNodeValue = $xmlObj->getElementsByTagName('Date')[0]->nodeValue;
        $matchDateTimestamp = strtotime($matchDateNodeValue);
        $matchDate = date('Y-m-d H:i:s', $matchDateTimestamp);

        foreach ($xmlObj->getElementsByTagName('TeamData') as $team) {
            $teamName = $team->getAttribute('Side');

            foreach ($team->getElementsByTagName('Goal') as $goal) {
                $goals[$teamName][] = [
                    'id' => $goal->getAttribute('EventID'),
                    'player_ref' => $goal->getAttribute('PlayerRef'),
                ];
            }

            $tackleCount = 0;
            $touchCount = 0;
            $foulCount = 0;

            foreach ($team->getElementsByTagName('MatchPlayer') as $player) {
                foreach ($team->getElementsByTagName('Stat') as $stat) {
                    switch ($stat->getAttribute('Type')) {
                        case 'total_tackle':
                            $tackleCount += (int) $stat->nodeValue;
                            break;
                        case 'touches':
                            $touchCount += (int) $stat->nodeValue;
                            break;
                        case 'fouls':
                            $foulCount += (int) $stat->nodeValue;
                            break;
                    }
                }
            }

            $tackles[$teamName] = $tackleCount;
            $touches[$teamName] = $touchCount;
            $fouls[$teamName] = $foulCount;

            foreach ($team->getElementsByTagName('Booking') as $booking) {
                if ($booking->getAttribute('Card') == 'Yellow') {
                    $yellowCards++;
                } else {
                    $redCards++;
                }
            }
        }

        return [
            'matchDate' => $matchDate,
            'goals' => $goals,
            'tackles' => $tackles,
            'touches' => $touches,
            'fouls' => $fouls,
            'redCards' => $redCards,
            'yellowCards' => $yellowCards,
        ];
    }
}
