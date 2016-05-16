<?php namespace App\Services\Repository;

use App\Match;
use App\Summoner;
use Illuminate\Database\Eloquent\Collection;

class StaticRepository extends Repository
{
    /**
     * @return mixed
     */
    public function getChampions() {
        $cacheKey = "static:champions";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache) {
            $res = $this->client->request('GET', $this->baseurl . '/static/champion', [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }

    /**
     * @return mixed
     */
    public function getRunes() {
        $cacheKey = "static:runes";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache) {
            $res = $this->client->request('GET', $this->baseurl . '/static/rune', [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }

    /**
     * @return mixed
     */
    public function getMasteries() {
        $cacheKey = "static:masteries";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache) {
            $res = $this->client->request('GET', $this->baseurl . '/static/mastery', [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }

    /**
     * @param $version
     *
     * @return mixed
     */
    public function getItems($version) {
        $cacheKey = "static:items:{$version}";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache, $version) {
            $res = $this->client->request('GET', $this->baseurl . "/static/item/{$version}", [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }

    /**
     * @return mixed
     */
    public function getSummonerSpells() {
        $cacheKey = "static:summoner-spells";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache) {
            $res = $this->client->request('GET', $this->baseurl . '/static/summoner-spell', [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }

    /**
     * @return mixed
     */
    public function getRealm() {
        $cacheKey = "static:realm";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache) {
            $res = $this->client->request('GET', $this->baseurl . '/static/realm', [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }

    /**
     * @return mixed
     */
    public function getVersions() {
        $cacheKey = "static:versions";
        $cache = $this->cache;

        return $this->cache->get($cacheKey, function() use($cacheKey, $cache) {
            $res = $this->client->request('GET', $this->baseurl . '/static/versions', [
                'query' => ['region' => 'EUW'],
                'connect_timeout' => 5,
                'timeout' => 10,
            ]);

            $res = json_decode($res->getBody());
            $cache->put($cacheKey, $res, 60*24);

            return $res;
        });
    }
}