<?php

namespace Geocoding;

use \Cache;
use Carbon\Carbon;

trait CachingQueries
{

    private $prefix = 'geocoding_';

    /**
     * @param $method
     * @param $path
     * @return mixed
     */
    public function hasQueryCache($method, $path)
    {
        $key = $this->makeCacheKey($method, $path);

        return Cache::has($key);
    }

    /**
     * @param $method
     * @param $path
     * @return mixed
     */
    public function getQueryFromCache($method, $path)
    {
        $key = $this->makeCacheKey($method, $path);

        return Cache::get($key);
    }

    /**
     * @param $method
     * @param $path
     * @param $data
     * @return mixed
     */
    public function setQuerytoCache($method, $path, $data)
    {
        $key = $this->makeCacheKey($method, $path);

        return Cache::put($key, $data, Carbon::now()->addDays(2));
    }

    /**
     * @param $method
     * @param $path
     * @return string
     */
    private function makeCacheKey($method, $path)
    {
        $key = sprintf('%s:%s:', $method, $path);

        return $this->prefix . md5((count($this->query) === 0) ? $key : $key . http_build_query($this->query));
    }
}