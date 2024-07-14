<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\GetHistoryDataRequest;
use App\Response\HistoryDataResponse;
use App\Service\HistoryDataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HistoryDataController extends AbstractController
{
    public function __construct(
        private readonly HistoryDataService $historyDataService
    ) {
    }

    #[Route('/histories', methods: ['GET'])]
    public function getAction(GetHistoryDataRequest $request): JsonResponse
    {
        $this->validateRequest($request);

        $historyData = $this->historyDataService->getHistoryData(
            $request->getCompanySymbol(),
            $request->getDateFrom(),
            $request->getDateTo()
        );

        return new HistoryDataResponse($historyData);
    }
}
