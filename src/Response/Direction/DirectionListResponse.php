<?php

declare(strict_types=1);

namespace App\Response\Direction;

use App\Response\AbstractResponse;
use App\Response\Service\ServiceListData;

class DirectionListResponse extends AbstractResponse
{
    private DirectionListDirectionData $direction;

    /**
     * @var ServiceListData[]
     */
    private array $services;

    public function getDirection(): DirectionListDirectionData
    {
        return $this->direction;
    }

    public function setDirection(DirectionListDirectionData $direction): void
    {
        $this->direction = $direction;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function setServices(array $services): void
    {
        $this->services = $services;
    }
}
