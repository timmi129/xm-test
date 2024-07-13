<?php

declare(strict_types=1);

namespace App\Validator\Constraints\VO;

use App\VO\AbstractInt;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IntVOValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IntVO) {
            throw new UnexpectedTypeException($constraint, IntVO::class);
        }

        if (null === $value) {
            return;
        }

        if (!$value instanceof AbstractInt) {
            throw new UnexpectedValueException($value, AbstractInt::class);
        }

        $context = $this->context;
        $validator = $context->getValidator()->inContext($context);
        $validator->validate($value->getValue(), $constraint->constraints);
    }
}
