<?php

declare(strict_types=1);

namespace App\Validator\Constraints\VO;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class StringVO extends Constraint
{
    public array $constraints = [];

    public function getDefaultOption()
    {
        return 'constraints';
    }
}
