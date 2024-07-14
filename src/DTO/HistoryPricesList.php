<?php

declare(strict_types=1);

namespace App\DTO;

class HistoryPricesList
{
    /**
     * @var HistoryPrice[]
     */
    private array $prices;

    public function getPrices(): array
    {
        return $this->prices;
    }

    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }
}
