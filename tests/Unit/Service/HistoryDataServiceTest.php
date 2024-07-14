<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repository\Service;

use App\DTO\HistoryPrice;
use App\DTO\HistoryPricesList;
use App\Repository\HistoryRepositoryInterface;
use App\Service\HistoryDataService;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HistoryDataServiceTest extends TestCase
{
    private HistoryRepositoryInterface|MockObject $repository;

    private HistoryDataService $service;

    public function testGetHistoryDataSuccess(): void
    {
        $price1 = new HistoryPrice();
        $price1->setDate(DateTime::createFromFormat('m-d-Y', '10-16-2020')->getTimestamp());
        $price1->setLow(1.0);
        $price1->setClose(1.0);
        $price1->setHigh(1.0);
        $price1->setOpen(1.0);
        $price1->setVolume(1.0);

        $price2 = new HistoryPrice();
        $price2->setDate(DateTime::createFromFormat('m-d-Y', '10-16-2023')->getTimestamp());
        $price2->setLow(2.0);
        $price2->setClose(2.0);
        $price2->setHigh(2.0);
        $price2->setOpen(2.0);
        $price2->setVolume(2.0);

        $price3 = new HistoryPrice();
        $price3->setDate(DateTime::createFromFormat('m-d-Y', '10-16-2024')->getTimestamp());
        $price3->setLow(3.0);
        $price3->setClose(3.0);
        $price3->setHigh(3.0);
        $price3->setOpen(3.0);
        $price3->setVolume(3.0);
        $prices = new HistoryPricesList();
        $prices->setPrices([$price1, $price2, $price3]);
        $symbol = 'AAL';

        $dateFrom = DateTime::createFromFormat('m-d-Y', '08-16-2023');
        $dateTo = DateTime::createFromFormat('m-d-Y', '11-16-2023');

        $this->repository->expects($this->once())
            ->method('getHistoryData')
            ->with($symbol)
            ->willReturn($prices);

        $result = $this->service->getHistoryData($symbol, $dateFrom, $dateTo);

        $this->assertCount(1, $result->getPrices());
        $this->assertSame($price2->getDate(), $result->getPrices()[0]->getDate());
        $this->assertSame($price2->getVolume(), $result->getPrices()[0]->getVolume());
        $this->assertSame($price2->getClose(), $result->getPrices()[0]->getClose());
        $this->assertSame($price2->getHigh(), $result->getPrices()[0]->getHigh());
        $this->assertSame($price2->getLow(), $result->getPrices()[0]->getLow());
        $this->assertSame($price2->getOpen(), $result->getPrices()[0]->getOpen());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(HistoryRepositoryInterface::class);
        $this->service = new HistoryDataService($this->repository);
    }
}
