<?php

declare(strict_types=1);

namespace App\Validator\Constraints\VO;

use App\VO\AbstractString;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class StringVOValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof StringVO) {
            throw new UnexpectedTypeException($constraint, StringVO::class);
        }

        if (null === $value) {
            return;
        }

        if (!$value instanceof AbstractString) {
            throw new UnexpectedValueException($value, AbstractString::class);
        }

        $context = $this->context;
        $validator = $context->getValidator()->inContext($context);
        $validator->validate($value->getValue(), $constraint->constraints);
    }
}
