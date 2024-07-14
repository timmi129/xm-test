<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CompanyRepository;
use DateTime;

class EmailService
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly MailSenderInterface $mailClient
    ) {
    }

    public function sendEmail(
        string $email,
        string $companySymbol,
        DateTime $dateFrom,
        DateTime $dateTo,
    ): void {
        $company = $this->companyRepository->getBySymbol($companySymbol);

        $this->mailClient->sendEmail(
            $email,
            $company->getName(),
            'From ' . $dateFrom->format('Y-m-d') . ' to ' . $dateTo->format('Y-m-d')
        );
    }
}
