<?php

declare(strict_types=1);

namespace App\Request;

use App\Validator\Constraints\CompanySymbol;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class GetHistoryDataRequest implements RequestInterface
{
    #[Assert\NotBlank()]
    #[CompanySymbol()]
    private string $companySymbol;

    #[Assert\NotBlank()]
    #[Assert\LessThanOrEqual('today')]
    #[Assert\LessThanOrEqual(propertyPath: 'dateTo')]
    private DateTime $dateFrom;

    #[Assert\NotBlank()]
    #[Assert\LessThanOrEqual('today')]
    #[Assert\GreaterThanOrEqual(propertyPath: 'dateFrom')]
    private DateTime $dateTo;

    public function getCompanySymbol(): string
    {
        return $this->companySymbol;
    }

    public function setCompanySymbol(string $companySymbol): void
    {
        $this->companySymbol = $companySymbol;
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function setDateFrom(DateTime $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(DateTime $dateTo): void
    {
        $this->dateTo = $dateTo;
    }
}
