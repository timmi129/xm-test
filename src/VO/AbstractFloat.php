<?php

declare(strict_types=1);

namespace App\VO;

use JsonSerializable;

abstract class AbstractFloat implements JsonSerializable
{
    protected float $value;

    protected function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function equals(self $value): bool
    {
        return $this->value === $value->value;
    }

    public function jsonSerialize(): float
    {
        return $this->value;
    }

    public static function create(float $value): static
    {
        /* @phpstan-ignore-next-line */
        return new static($value);
    }
}
