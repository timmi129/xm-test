<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'companies')]
class Company
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $financialStatus;

    #[ORM\Column(type: 'string')]
    private string $marketCategory;

    #[ORM\Column(type: 'decimal')]
    private float $roundLotSize;

    #[ORM\Column(type: 'string')]
    private string $securityName;

    #[ORM\Column(type: 'string')]
    private string $symbol;

    #[ORM\Column(type: 'string')]
    private string $testIssue;

    public function __construct(
        string $name,
        string $financialStatus,
        string $marketCategory,
        float $roundLotSize,
        string $securityName,
        string $symbol,
        string $testIssue
    ) {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->financialStatus = $financialStatus;
        $this->marketCategory = $marketCategory;
        $this->roundLotSize = $roundLotSize;
        $this->securityName = $securityName;
        $this->symbol = $symbol;
        $this->testIssue = $testIssue;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFinancialStatus(): string
    {
        return $this->financialStatus;
    }

    public function getMarketCategory(): string
    {
        return $this->marketCategory;
    }

    public function getRoundLotSize(): int
    {
        return $this->roundLotSize;
    }

    public function getSecurityName(): string
    {
        return $this->securityName;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getTestIssue(): string
    {
        return $this->testIssue;
    }
}
