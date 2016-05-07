<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\MatchRepository;

class MatchController extends Controller
{
    public function getMatchForSummoner(MatchRepository $repository, $region, $matchId, $summonerId)
    {
        /**
         * @var \App\Match $match
         */
        $match = $repository->get(explode(',', $matchId), $region);
        $matchData = $match->toArray();

        unset($matchData->timeline);

        foreach($matchData->participants as $participant) {
            unset($participant->runes);

            if (isset($participant->player) && $participant->player->summonerId != $summonerId) {
                unset($participant->stats);
                unset($participant->timeline);
            }
        }

        $match->data = json_encode($matchData);

        return $match;
    }

    public function getMatch(MatchRepository $repository, $region, $matchId)
    {
        return $repository->get(explode(',', $matchId), $region);
    }
}
