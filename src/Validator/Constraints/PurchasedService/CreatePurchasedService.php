<?php

declare(strict_types=1);

namespace App\Validator\Constraints\PurchasedService;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class CreatePurchasedService extends Constraint
{
}
