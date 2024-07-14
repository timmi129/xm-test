<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\HistoryPricesList;
use App\Repository\HistoryRepositoryInterface;
use DateTime;

class HistoryDataService
{
    public function __construct(
        private readonly HistoryRepositoryInterface $historyRepository
    ) {
    }

    public function getHistoryData(string $companySymbol, DateTime $dateFrom, DateTime $dateTo): HistoryPricesList
    {
        $resultPrices = [];

        $dateFromTimeStamp = $dateFrom->getTimestamp();
        $dateToTimeStamp = $dateTo->getTimestamp();

        $historyData = $this->historyRepository->getHistoryData($companySymbol);

        foreach ($historyData->getPrices() as $price) {
            if ($price->getDate() >= $dateFromTimeStamp && $price->getDate() <= $dateToTimeStamp) {
                $resultPrices[] = $price;
            }
        }
        $historyData->setPrices($resultPrices);

        return $historyData;
    }
}
