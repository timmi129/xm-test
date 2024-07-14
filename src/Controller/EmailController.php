<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\SendEmailRequest;
use App\Service\EmailService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    public function __construct(
        private readonly EmailService $emailService
    ) {
    }

    #[Route('/emails', methods: ['POST'])]
    public function createAction(SendEmailRequest $request): JsonResponse
    {
        $this->validateRequest($request);

        $this->emailService->sendEmail(
            $request->getEmail(),
            $request->getCompanySymbol(),
            $request->getDateFrom(),
            $request->getDateTo()
        );

        //        mail(
        //                    'timmi129@yandex.ru',
        //            'my-email',
        //            'hi',
        //        );
        return new JsonResponse(null, Response::HTTP_OK);
    }
}
