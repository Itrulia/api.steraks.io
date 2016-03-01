<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\MatchRepository;

class MatchController extends Controller
{
    public function getMatch(MatchRepository $repository, $region, $matchId)
    {
        return $repository->get(explode(',', $matchId), $region);
    }
}
