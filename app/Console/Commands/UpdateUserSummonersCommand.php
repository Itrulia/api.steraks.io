<?php

namespace App\Console\Commands;

use App\Match;
use App\Services\Repository\MatchRepository;
use App\Services\Repository\SummonerRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateUserSummonersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update:summoners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the matches of summoners of user';

    /**
     * @var \App\Services\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * @var \App\Services\Repository\SummonerRepository
     */
    protected $summonerRepository;

    /**
     * Create a new command instance.
     */
    public function __construct(MatchRepository $matchRepository, SummonerRepository $summonerRepository)
    {
        parent::__construct();
        $this->matchRepository = $matchRepository;
        $this->summonerRepository = $summonerRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $summonerIds = User::all('summonerId')
            ->unique('summonerId')->map(function(User $user) {
                return $user->summonerId;
            });

        dd($summonerIds);

//        $matchIds = array_map(function($match) {
//            return $match->matchId;
//        }, $this->summonerRepository->getMatches(21422420, 'EUW'));
//
//        $matchIds = array_slice($matchIds, 0, 9);
//
//        $this->matchRepository->get($matchIds, 'EUW');
    }
}
