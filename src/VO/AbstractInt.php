<?php

declare(strict_types=1);

namespace App\VO;

use JsonSerializable;

abstract class AbstractInt implements JsonSerializable
{
    protected int $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(self $value): bool
    {
        return $this->value === $value->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public static function create(int $value): static
    {
        /* @phpstan-ignore-next-line */
        return new static($value);
    }
}
