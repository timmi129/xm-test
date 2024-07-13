<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Sort;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class SortChoices extends Constraint
{
    public array $choices;

    public string $message = '{{ value }} not in valid list {{ list }}';

    public function getDefaultOption(): ?string
    {
        return 'choices';
    }
}
