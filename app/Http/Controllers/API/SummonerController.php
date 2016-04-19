<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\SummonerRepository;

class SummonerController extends Controller
{
    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return mixed
     */
    public function getChampionMastery(SummonerRepository $repository, $region, $summonerId)
    {
        return json_encode($repository->getChampionMastery($summonerId, $region));
    }

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
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return array
     */
    public function synergy(SummonerRepository $repository, $region, $summonerId)
    {
        return $repository->getSynergies($summonerId, $region);
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return array
     */
    public function counters(SummonerRepository $repository, $region, $summonerId)
    {
        return $repository->getCounters($summonerId, $region);
    }

    /**
     * @param \App\Services\Repository\SummonerRepository $repository
     * @param $region
     * @param $summonerId
     *
     * @return array
     */
    public function friends(SummonerRepository $repository, $region, $summonerId)
    {
        return $repository->getFriends($summonerId, $region);
    }
}
