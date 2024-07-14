<?php

declare(strict_types=1);

namespace App\DTO;

class HistoryPrice
{
    private int $date;

    private float $open;

    private float $high;

    private float $low;

    private float $close;

    private float $volume;

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function setOpen(float $open): void
    {
        $this->open = $open;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function setHigh(float $high): void
    {
        $this->high = $high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function setLow(float $low): void
    {
        $this->low = $low;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function setClose(float $close): void
    {
        $this->close = $close;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): void
    {
        $this->volume = $volume;
    }
}
