<?php namespace App\Services\Repository;

class SummonerRepository extends Repository
{
    /**
     * @param $summonerId
     * @param $region
     *
     * @return array
     */
    public function getMatches($summonerId, $region)
    {
        $cacheKey = 'summoner:' . $summonerId . ':' . $region . ':matches';
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $cache, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/matches', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 15);

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
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $cache, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/runes', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 15);

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
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $cache, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/masteries', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 15);

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
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $cache, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/rank', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 15);

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
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $cache, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId . '/stats', [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 15);

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
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function () use ($cacheKey, $cache, $summonerId, $region) {
            $res = $this->client->request('GET', $this->baseurl . '/summoner/' . $summonerId, [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 15);

            return $res;
        });
    }
}