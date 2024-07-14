<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\HistoryPricesList;

interface HistoryRepositoryInterface
{
    public function getHistoryData(string $companySymbol): HistoryPricesList;
}
