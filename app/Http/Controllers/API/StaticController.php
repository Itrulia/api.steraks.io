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
        return response()->json($repository->getChampions());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getItems(StaticRepository $repository)
    {
        return response()->json($repository->getItems());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getSummonerSpells(StaticRepository $repository)
    {
        return response()->json($repository->getSummonerSpells());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getRunes(StaticRepository $repository)
    {
        return response()->json($repository->getRunes());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getMasteries(StaticRepository $repository)
    {
        return response()->json($repository->getMasteries());
    }

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     *
     * @return mixed
     */
    public function getRealm(StaticRepository $repository)
    {
        return response()->json($repository->getRealm());
    }

}
