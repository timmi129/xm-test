<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use function is_object;
use function method_exists;

final class ValidationException extends AbstractException
{
    /**
     * @var object|null
     */
    protected $model;

    /**
     * @var ConstraintViolationListInterface|ConstraintViolationInterface[]
     */
    protected $violations;

    /**
     * @return object|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return ConstraintViolationListInterface|ConstraintViolationInterface[]
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * @param ConstraintViolationListInterface|ConstraintViolationInterface[] $violations
     *
     * @return static
     *
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public static function create($violations, ?object $model = null)
    {
        $countExceptions = 0;

        if (is_object($violations) && method_exists($violations, 'count')) {
            $countExceptions = $violations->count();
        }

        $exception = new self(
            'Validation failed' . ($model ? ' for ' . $model::class : '')
            . ' with ' . $countExceptions . ' violation(s).'
        );

        $exception->model = $model;
        $exception->violations = $violations;

        return $exception;
    }
}
