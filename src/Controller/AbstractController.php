<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ValidationException;
use App\Request\RequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractController extends SymfonyAbstractController
{
    protected ValidatorInterface $validator;

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    protected function validateRequest(RequestInterface $request): void
    {
        $violations = $this->validator->validate($request);

        if (0 !== $violations->count()) {
            throw ValidationException::create($violations, $request);
        }
    }
}
