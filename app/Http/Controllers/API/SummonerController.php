<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\SummonerRepository;
use Illuminate\Database\Query\JoinClause;

class SummonerController extends Controller
{
    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return string
     */
    public function getMatches(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getMatches($summonerId, $region));
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return mixed
     */
    public function getRunes(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getRunes($summonerId, $region));
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return mixed
     */
    public function getMasteries(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getMasteries($summonerId, $region));
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return mixed
     */
    public function getRank(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getRank($summonerId, $region));
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return mixed
     */
    public function getStats(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getStats($summonerId, $region));
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return string
     */
    public function getSummoner(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getSummoner($summonerId, $region));
    }

    /**
     * @param $summonerId
     *
     * @TODO: Move to repository/refactory
     * @Bug: Own champion is included
     * @return array
     */
    public function synergy($region, $summonerId)
    {
        $games = \DB::table('match_summoner_champion')
            ->where('summonerId', $summonerId)->get();

        $games = array_map(function ($game) {
            return $game->matchId;
        }, $games);

        $games = \DB::table('match_summoner_champion AS t1')
            ->selectRaw('t1.matchId, t1.summonerId, t1.championId, t1.teamId, t1.winner')
            ->leftJoin('match_summoner_champion as t2', function (JoinClause $join) use ($summonerId, $games) {
                $join->on('t1.matchId', '=', 't2.matchId')
                    ->on('t1.teamId', '!=', 't2.teamId')
                    ->where('t2.summonerId', '=', $summonerId);
            })
            ->whereIn('t1.matchId', $games)
            ->whereNull('t2.matchId')
            ->get(['winner', 'championId', 'matchId']);

        $champions = [];
        foreach ($games as $game) {
            /** @var \stdClass $game */
            if (!isset($champions[$game->championId])) {
                $champions[$game->championId] = [
                    'championId' => $game->championId,
                    'games'      => 0,
                    'wins'       => 0,
                    'losses'     => 0
                ];
            }

            $champions[$game->championId]['games']++;

            if ($game->winner) {
                $champions[$game->championId]['wins']++;
            } else {
                $champions[$game->championId]['losses']++;
            }

            $champions[$game->championId]['percent'] = $champions[$game->championId]['wins']
                / $champions[$game->championId]['games'];
        }

        return $champions;
    }

    /**
     * @param $region
     * @param $summonerId
     *
     * @return array
     * @TODO: Move to repository/refactory
     */
    public function counters($region, $summonerId)
    {
        $games = \DB::table('match_summoner_champion')
            ->where('summonerId', $summonerId)->get();

        $games = array_map(function ($game) {
            return $game->matchId;
        }, $games);

        $games = \DB::table('match_summoner_champion AS t1')
            ->selectRaw('t1.matchId, t1.summonerId, t1.championId, t1.teamId, t1.winner')
            ->leftJoin('match_summoner_champion as t2', function (JoinClause $join) use ($summonerId, $games) {
                $join->on('t1.matchId', '=', 't2.matchId')
                    ->on('t1.teamId', '=', 't2.teamId')
                    ->where('t2.summonerId', '=', $summonerId);
            })
            ->whereIn('t1.matchId', $games)
            ->whereNull('t2.matchId')
            ->get(['winner', 'championId', 'matchId']);

        $champions = [];
        foreach ($games as $game) {
            /** @var \stdClass $game */
            if (!isset($champions[$game->championId])) {
                $champions[$game->championId] = [
                    'championId' => $game->championId,
                    'games'      => 0,
                    'wins'       => 0,
                    'losses'     => 0
                ];
            }

            $champions[$game->championId]['games']++;

            if (!$game->winner) {
                $champions[$game->championId]['wins']++;
            } else {
                $champions[$game->championId]['losses']++;
            }

            $champions[$game->championId]['percent'] = $champions[$game->championId]['wins']
                / $champions[$game->championId]['games'];
        }

        return $champions;
    }
}
