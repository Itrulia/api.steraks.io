<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\MatchRepository;
use App\Services\Repository\SummonerRepository;

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
}
