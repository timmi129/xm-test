<?php

declare(strict_types=1);

namespace App\Repository\Cache;

use App\DTO\HistoryPricesList;
use App\Repository\HistoryRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class HistoryCacheRepository implements HistoryRepositoryInterface
{
    private const TTL = 600;

    private const KEY = 'history_cache';

    public function __construct(
        private readonly HistoryRepositoryInterface $decorates,
        private readonly CacheItemPoolInterface $cache,
    ) {
    }

    public function getHistoryData(string $companySymbol): HistoryPricesList
    {
        $cacheItem = $this->cache->getItem($this->getKey($companySymbol));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->decorates->getHistoryData($companySymbol);

        $cacheItem->set($data);
        $cacheItem->expiresAfter(self::TTL);

        $this->cache->save($cacheItem);

        return $data;
    }

    private function getKey(string $companySymbol): string
    {
        return self::KEY . '_' . $companySymbol;
    }
}
