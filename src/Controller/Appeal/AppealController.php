<?php

declare(strict_types=1);

namespace App\Controller\Appeal;

use App\Controller\AbstractController;
use App\Request\Appeal\CreateAppealRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppealController extends AbstractController
{
    #[Route('/appeals', methods: ['POST'])]
    public function createAction(CreateAppealRequest $request): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
