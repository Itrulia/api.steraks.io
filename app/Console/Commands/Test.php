<?php

namespace App\Console\Commands;

use App\Match;
use App\Services\Repository\MatchRepository;
use App\Services\Repository\SummonerRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test';

    protected $repository;
    protected $repository2;

    /**
     * Create a new command instance.
     */
    public function __construct(MatchRepository $repository, SummonerRepository $repository2)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->repository2 = $repository2;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $matchIds = array_map(function($match) {
            return $match->matchId;
        }, $this->repository2->getMatches(21422420, 'EUW'));

        $matchIds = array_slice($matchIds, 0, 9);

        $this->repository->get($matchIds, 'EUW');
    }
}
