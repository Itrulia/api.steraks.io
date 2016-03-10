<?php namespace App\Services\Repository;

use App\Services\Data\StaticService;
use GuzzleHttp\Client;
use Illuminate\Cache\Repository as Cache;

abstract class Repository
{
    /**
     * @var string
     */
    protected $baseurl = 'http://localhost:4000';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Illuminate\Cache\Repository
     */
    protected $cache;

    /**
     * @param \GuzzleHttp\Client $client
     * @param \Illuminate\Cache\Repository $cache
     */
    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }
}