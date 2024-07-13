<?php

declare(strict_types=1);

namespace App\Validator\Constraints\PurchasedService;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

use function is_array;

class CreatePurchasedServiceValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CreatePurchasedService) {
            throw new UnexpectedTypeException($constraint, CreatePurchasedService::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        // TODO add validation

        //        $context = $this->context;
        //        $validator = $context->getValidator()->inContext($context);
        //        $validator->validate($value->getValue(), $constraint->constraints);
    }
}
