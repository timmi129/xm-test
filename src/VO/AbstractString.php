<?php

declare(strict_types=1);

namespace App\VO;

abstract class AbstractString
{
    protected string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(self $vo): bool
    {
        return $this->value === $vo->value;
    }

    public static function create(string $value): static
    {
        /* @phpstan-ignore-next-line */
        return new static($value);
    }
}
