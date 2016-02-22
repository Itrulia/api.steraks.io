<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\MatchRepository;
use App\Services\Repository\StaticRepository;
use App\Services\Repository\SummonerRepository;

class StaticController extends Controller
{
    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getChampions(StaticRepository $repository)
    {
        return json_encode($repository->getChampions());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getItems(StaticRepository $repository)
    {
        return json_encode($repository->getItems());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getSummonerSpells(StaticRepository $repository)
    {
        return json_encode($repository->getSummonerSpells());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getRealm(StaticRepository $repository)
    {
        return json_encode($repository->getRealm());
    }

}
