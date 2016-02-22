<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Repository\MatchRepository;

class MatchController extends Controller
{
    public function getMatch($matchId, MatchRepository $repository)
    {
        return $repository->get(explode(',', $matchId), 'EUW');
    }
}
