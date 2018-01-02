<?php

namespace TypiCMS\Modules\History\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Shells\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements HistoryInterface
{
    public function __construct(HistoryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Clear history.
     *
     * @return bool
     */
    public function clear()
    {
        $this->cache->flush();
        $this->cache->flush('dashboard');

        return $this->repo->clear();
    }

    /**
     * Get latest models.
     *
     * @param int   $number number of items to take
     * @param array $with   array of related items
     *
     * @return Collection
     */
    public function versions($model, $number = 25)
    {
        $cacheKey = md5($this->cachePrefix().'versions'.serialize($model).$number);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->versions($model, $number);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
