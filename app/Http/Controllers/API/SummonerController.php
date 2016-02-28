<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\MatchRepository;
use App\Services\Repository\SummonerRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

class SummonerController extends Controller
{
    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $summonerId
     *
     * @return string
     */
    public function getMatches(SummonerRepository $repository, $summonerId) {
        return json_encode($repository->getMatches($summonerId, 'EUW'));
    }

    /**
     * @param $summonerId
     * @param \App\Services\Repository\SummonerRepository $repository
     *
     * @return mixed
     */
    public function getRunes(SummonerRepository $repository, $summonerId)
    {
        return json_encode($repository->getRunes($summonerId, 'EUW'));
    }

    /**
     * @param $summonerId
     * @param \App\Services\Repository\SummonerRepository $repository
     *
     * @return mixed
     */
    public function getMasteries(SummonerRepository $repository, $summonerId)
    {
        return json_encode($repository->getMasteries($summonerId, 'EUW'));
    }

    /**
     * @param $summonerId
     * @param \App\Services\Repository\SummonerRepository $repository
     *
     * @return mixed
     */
    public function getRank(SummonerRepository $repository, $summonerId)
    {
        return json_encode($repository->getRank($summonerId, 'EUW'));
    }

    /**
     * @param $summonerId
     * @param \App\Services\Repository\SummonerRepository $repository
     *
     * @return mixed
     */
    public function getStats(SummonerRepository $repository, $summonerId)
    {
        return json_encode($repository->getStats($summonerId, 'EUW'));
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $summonerId
     *
     * @return string
     */
    public function getSummoner(SummonerRepository $repository, $summonerId)
    {
        return json_encode($repository->getSummoner($summonerId, 'EUW'));
    }

    /**
     * @param $summonerId
     */
    public function follow($summonerId) {

    }

    public function unfollow($summonerId) {

    }

    public function synergy($summonerId) {
        $games = \DB::table('match_summoner_champion')
            ->where('summonerId', $summonerId)->get();

        $games = array_map(function($game) {
            return $game->matchId;
        }, $games);

        $games = \DB::table('match_summoner_champion AS t1')
            ->selectRaw('t1.matchId, t1.summonerId, t1.championId, t1.teamId, t1.winner')
            ->leftJoin('match_summoner_champion as t2', function(JoinClause $join) use ($summonerId, $games) {
                $join->on('t1.matchId' , '=', 't2.matchId')
                    ->on('t1.teamId' ,'!=' ,'t2.teamId')
                    ->where('t2.summonerId',    '=', $summonerId);
            })
            ->whereIn('t1.matchId', $games)
            ->whereNull('t2.matchId')
            ->get(['winner', 'championId', 'matchId']);

        $champions = [];
        foreach($games as $game) {
            if (!isset($champions[$game->championId])) {
                $champions[$game->championId] = [
                    'championId' => $game->championId,
                    'games' => 0,
                    'wins' => 0,
                    'losses' => 0
                ];
            }

            $champions[$game->championId]['games']++;

            if ($game->winner) {
                $champions[$game->championId]['wins']++;
            } else {
                $champions[$game->championId]['losses']++;
            }

            $champions[$game->championId]['percent'] = $champions[$game->championId]['wins'] / $champions[$game->championId]['games'];
        }

        return $champions;
    }

    public function counters($summonerId) {
        $games = \DB::table('match_summoner_champion')
            ->where('summonerId', $summonerId)->get();

        $games = array_map(function($game) {
            return $game->matchId;
        }, $games);

        $games = \DB::table('match_summoner_champion AS t1')
            ->selectRaw('t1.matchId, t1.summonerId, t1.championId, t1.teamId, t1.winner')
            ->leftJoin('match_summoner_champion as t2', function(JoinClause $join) use ($summonerId, $games) {
                $join->on('t1.matchId' , '=', 't2.matchId')
                    ->on('t1.teamId' ,'=' ,'t2.teamId')
                    ->where('t2.summonerId', '=', $summonerId);
            })
            ->whereIn('t1.matchId', $games)
            ->whereNull('t2.matchId')
            ->get(['winner', 'championId', 'matchId']);

        $champions = [];
        foreach($games as $game) {
            if (!isset($champions[$game->championId])) {
                $champions[$game->championId] = [
                    'championId' => $game->championId,
                    'games' => 0,
                    'wins' => 0,
                    'losses' => 0
                ];
            }

            $champions[$game->championId]['games']++;

            if (!$game->winner) {
                $champions[$game->championId]['wins']++;
            } else {
                $champions[$game->championId]['losses']++;
            }

            $champions[$game->championId]['percent'] = $champions[$game->championId]['wins'] / $champions[$game->championId]['games'];
        }

        return $champions;
    }
}
