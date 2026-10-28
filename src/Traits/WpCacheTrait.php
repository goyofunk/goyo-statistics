<?php

namespace Goyo_Statistics\Traits;

/**
 * Trait to handle caching logic using WordPress Object Cache.
 */
trait WpCacheTrait
{
    /**
     * Cache group name to avoid collisions.
     *
     * @var string
     */
    protected $cacheGroup = 'goyo_statistics';

    private function getCacheGroup()
    {
        return $this->cacheGroup . '_' . get_option('goyo_statistics_cache_generation', '0');
    }

    /**
     * Sets a value in the cache.
     *
     * @param string $key   Cache key.
     * @param mixed  $value Value to cache.
     * @param mixed  $expire Expiration time in seconds.
     *
     * @return bool True on success, false on failure.
     */
    public function setCache($key, $value, $expire = 0)
    {
        return wp_cache_set($key, $value, $this->getCacheGroup(), $expire);
    }

    /**
     * Gets a value from the cache.
     *
     * @param string $key     Cache key.
     * @param mixed  $default Default value if not found.
     *
     * @return mixed
     */
    public function getCache($key, $default = null)
    {
        $value = wp_cache_get($key, $this->getCacheGroup());

        return ($value === false) ? $default : $value;
    }

    /**
     * Checks if a cache key is set.
     *
     * @param string $key Cache key.
     *
     * @return bool
     */
    public function isCacheSet($key)
    {
        return wp_cache_get($key, $this->getCacheGroup()) !== false;
    }

    /**
     * Deletes a value from the cache.
     *
     * @param string $key Cache key.
     *
     * @return bool True on success, false on failure.
     */
    public function deleteCache($key)
    {
        return wp_cache_delete($key, $this->getCacheGroup());
    }

    /**
     * Fetches data with caching.
     *
     * @param string   $key      Cache key.
     * @param string   $expire   Expiration in seconds.
     * @param callable $callback Function to fetch data if not cached.
     *
     * @return mixed
     */
    public function getCachedData($key, callable $callback, $expire = 0)
    {
        $value = wp_cache_get($key, $this->getCacheGroup());

        if ($value === false) {
            $value = $callback();
            $this->setCache($key, $value, $expire);
        }

        return $value;
    }
}
