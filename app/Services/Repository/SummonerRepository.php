<?php namespace App\Services\Repository;

use App\Services\Data\SummonerService;
use GuzzleHttp\Client;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Cache\Repository as Cache;

class SummonerRepository extends Repository
{
    /**
     * @var \App\Services\Data\SummonerService
     */
    protected $service;

    /**
     * @param \GuzzleHttp\Client $client
     * @param \Illuminate\Cache\Repository $cache
     * @param \App\Services\Data\SummonerService $service
     */
    public function __construct(Client $client, Cache $cache, SummonerService $service)
    {
        $this->service = $service;
        parent::__construct($client, $cache);
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return array
     */
    public function getMatches($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':matches';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/matches', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            if (is_null($res)) {
                $res = [];
            }
            $res = $this->service->setMatches($res);
            $this->cache->put($cacheKey, $res, 1);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return mixed
     */
    public function getRunes($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':runes';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/runes', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $this->service->setRunes($res);

            $this->cache->put($cacheKey, $res, 15);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return mixed
     */
    public function getMasteries($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':masteries';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/masteries', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $this->cache->put($cacheKey, $res, 15);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return mixed
     */
    public function getRank($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':rank';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/rank', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $this->cache->put($cacheKey, $res, 15);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return mixed
     */
    public function getStats($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':stats';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/stats', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $res = $this->service->setStats($res);
            $this->cache->put($cacheKey, $res, 15);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return string
     */
    public function getSummoner($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId, [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());

            if (count(explode(',', $summonerId)) > 1) {
                foreach(get_object_vars($res) as $id => $value) {
                    $res->$id = $this->service->setSummonerIcon($res->$id);
                }
            } else {
                $res = $this->service->setSummonerIcon($res);
            }

            $this->cache->put($cacheKey, $res, 15);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return mixed
     */
    public function getChampionMastery($summonerId, $region) {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':championmastery';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/championmastery', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $res = $this->service->setChampionMastery($res);

            $this->cache->put($cacheKey, $res, 15);

            return $res;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return array
     */
    public function getCounters($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':counters';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
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
                        'matchIds'   => [],
                        'games'      => 0,
                        'wins'       => 0,
                        'losses'     => 0
                    ];

                    list($champions[$game->championId]['championName'], $champions[$game->championId]['championAvatar']) = $this->service->getChampionData($game->championId);
                }

                $champions[$game->championId]['matchIds'][] = $game->matchId;
                $champions[$game->championId]['games']++;

                if (!$game->winner) {
                    $champions[$game->championId]['wins']++;
                } else {
                    $champions[$game->championId]['losses']++;
                }

                $champions[$game->championId]['percent'] = $champions[$game->championId]['wins']
                    / $champions[$game->championId]['games'];
            }


            $this->cache->put($cacheKey, $champions, 15);

            return $champions;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return array
     */
    public function getSynergies($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':synergies';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
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
                ->where('t1.summonerId', '!=', $summonerId)
                ->whereNull('t2.matchId')
                ->get(['winner', 'championId', 'matchId']);

            $champions = [];
            foreach ($games as $game) {
                /** @var \stdClass $game */
                if (!isset($champions[$game->championId])) {
                    $champions[$game->championId] = [
                        'championId' => $game->championId,
                        'matchIds'   => [],
                        'games'      => 0,
                        'wins'       => 0,
                        'losses'     => 0
                    ];

                    list($champions[$game->championId]['championName'], $champions[$game->championId]['championAvatar']) = $this->service->getChampionData($game->championId);
                }

                $champions[$game->championId]['matchIds'][] = $game->matchId;
                $champions[$game->championId]['games']++;

                if ($game->winner) {
                    $champions[$game->championId]['wins']++;
                } else {
                    $champions[$game->championId]['losses']++;
                }

                $champions[$game->championId]['percent'] = $champions[$game->championId]['wins']
                    / $champions[$game->championId]['games'];
            }

            $this->cache->put($cacheKey, $champions, 15);

            return $champions;
        });
    }

    /**
     * @param $summonerId
     * @param $region
     *
     * @return mixed
     */
    public function getFriends($summonerId, $region) {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':friends';

        return $this->cache->get($cacheKey, function () use ($cacheKey, $summonerId, $region) {
            $games = \DB::table('match_summoner_champion')
                ->where('summonerId', $summonerId)
                ->orderBy('matchId', 'DESC')
                ->limit(20)->get();

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
                ->where('t1.summonerId', '!=', $summonerId)
                ->whereNull('t2.matchId')
                ->get(['winner', 'summonerId', 'matchId']);

            $friends = [];
            foreach ($games as $game) {
                /** @var \stdClass $game */
                if (!isset($friends[$game->summonerId])) {
                    $friends[$game->summonerId] = [
                        'summonerId' => $game->summonerId,
                        'matchIds'   => [],
                        'games'      => 0,
                        'wins'       => 0,
                        'losses'     => 0
                    ];
                }

                $friends[$game->summonerId]['matchIds'][] = $game->matchId;
                $friends[$game->summonerId]['games']++;

                if ($game->winner) {
                    $friends[$game->summonerId]['wins']++;
                } else {
                    $friends[$game->summonerId]['losses']++;
                }

                $friends[$game->summonerId]['percent'] = $friends[$game->summonerId]['wins']
                    / $friends[$game->summonerId]['games'];
            }

            $friends = array_filter($friends, function($friend) {
                return $friend['games'] >= 2;
            });

            $this->cache->put($cacheKey, $friends, 15);

            return $friends;
        });
    }
}