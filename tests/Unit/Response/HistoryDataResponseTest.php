<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response;

use App\DTO\HistoryPrice;
use App\DTO\HistoryPricesList;
use App\Response\HistoryDataResponse;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HistoryDataResponseTest extends TestCase
{
    public function testSuccess(): void
    {
        $price = new HistoryPrice();
        $price->setDate(12412521525);
        $price->setLow(25.1);
        $price->setClose(32.1);
        $price->setHigh(55.1);
        $price->setOpen(11.1);
        $price->setVolume(1111.1);
        $exceptedResponse = new HistoryPricesList();
        $exceptedResponse->setPrices([$price]);

        $response = new HistoryDataResponse($exceptedResponse);

        $this->assertSame([
            'prices' => [
                [
                    'open' => 11.1,
                    'high' => 55.1,
                    'low' => 25.1,
                    'close' => 32.1,
                    'volume' => 1111.1,
                    'date' => 12412521525,
                ],
            ],
        ], json_decode($response->getContent(), true));
    }
}
