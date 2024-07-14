<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Repository\CompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CompanySymbolValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CompanySymbol) {
            throw new UnexpectedTypeException($constraint, CompanySymbol::class);
        }

        $company = $this->companyRepository->findBySymbol((string) $value);

        if (null === $company) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
