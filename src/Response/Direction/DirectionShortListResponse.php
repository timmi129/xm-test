<?php

declare(strict_types=1);

namespace App\Response\Direction;

use App\Response\AbstractResponse;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\UuidInterface;

class DirectionShortListResponse extends AbstractResponse
{
    #[OA\Property(type: 'string')]
    private UuidInterface $id;

    private string $name;

    private string $description;

    private string $title;

    private string $abbreviation;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }
}
