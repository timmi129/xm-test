<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Sort;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

use function in_array;
use function is_array;

class SortChoicesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SortChoices) {
            throw new UnexpectedTypeException($constraint, SortChoices::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $sort) {
            if (!in_array($sort->getName(), $constraint->choices, true)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $sort->getName())
                    ->setParameter('{{ list }}', implode(',', $constraint->choices))
                    ->addViolation();
            }
        }
    }
}
