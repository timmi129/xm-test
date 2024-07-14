<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repository\Cache;

use App\DTO\HistoryPrice;
use App\DTO\HistoryPricesList;
use App\Repository\Cache\HistoryCacheRepository;
use App\Repository\HistoryRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @internal
 */
final class HistoryCacheRepositoryTest extends TestCase
{
    private CacheItemPoolInterface|MockObject $cachePool;

    private CacheItemPoolInterface|MockObject $decorates;

    private HistoryCacheRepository $repository;

    public function testGetHistoryDataCacheNotFound(): void
    {
        $price = new HistoryPrice();
        $exceptedResponse = new HistoryPricesList();
        $exceptedResponse->setPrices([$price]);
        $symbol = 'AAL';
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem
            ->expects($this->once())
            ->method('isHit')
            ->willReturn(false);

        $this->cachePool
            ->expects($this->once())
            ->method('getItem')
            ->with('history_cache_AAL')
            ->willReturn($cacheItem);

        $this->cachePool
            ->expects($this->once())
            ->method('save')
            ->with($cacheItem);

        $this->decorates->expects($this->once())
            ->method('getHistoryData')
            ->willReturn($exceptedResponse);

        $response = $this->repository->getHistoryData($symbol);

        $this->assertSame($exceptedResponse, $response);
    }

    public function testGetHistoryDataGetDataFromCache(): void
    {
        $price = new HistoryPrice();
        $exceptedResponse = new HistoryPricesList();
        $exceptedResponse->setPrices([$price]);
        $symbol = 'AAL';
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem
            ->expects($this->once())
            ->method('isHit')
            ->willReturn(true);

        $cacheItem
            ->expects($this->once())
            ->method('get')
            ->willReturn($exceptedResponse);

        $this->cachePool
            ->expects($this->once())
            ->method('getItem')
            ->with('history_cache_AAL')
            ->willReturn($cacheItem);

        $this->cachePool
            ->expects($this->never())
            ->method('save');

        $this->decorates->expects($this->never())
            ->method('getHistoryData');

        $response = $this->repository->getHistoryData($symbol);

        $this->assertSame($exceptedResponse, $response);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->cachePool = $this->createMock(CacheItemPoolInterface::class);
        $this->decorates = $this->createMock(HistoryRepositoryInterface::class);
        $this->repository = new HistoryCacheRepository($this->decorates, $this->cachePool);
    }
}
