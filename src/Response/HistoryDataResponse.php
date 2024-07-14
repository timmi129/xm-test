<?php

declare(strict_types=1);

namespace App\Response;

use App\DTO\HistoryPricesList;
use Symfony\Component\HttpFoundation\JsonResponse;

class HistoryDataResponse extends JsonResponse
{
    public function __construct(HistoryPricesList $data)
    {
        $result = [
            'prices' => [],
        ];

        foreach ($data->getPrices() as $price) {
            $resultPrice = [
                'open' => $price->getOpen(),
                'high' => $price->getHigh(),
                'low' => $price->getLow(),
                'close' => $price->getClose(),
                'volume' => $price->getVolume(),
                'date' => $price->getDate(),
            ];

            $result['prices'][] = $resultPrice;
        }

        parent::__construct($result, JsonResponse::HTTP_OK);
    }
}
