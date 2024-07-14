<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repository\Service;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Service\EmailService;
use App\Service\MailSenderInterface;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @internal
 */
final class EmailServiceTest extends TestCase
{
    private CacheItemPoolInterface|MockObject $companyRepository;

    private MailSenderInterface|MockObject $mailClient;

    private EmailService $service;

    public function testSendEmailNotFoundCompany(): void
    {
        $mail = 'test@test.com';
        $symbol = 'AAL';
        $dateFrom = DateTime::createFromFormat('m-d-Y', '10-16-2003');
        $dateTo = DateTime::createFromFormat('m-d-Y', '10-16-2015');

        $this->companyRepository->expects($this->once())
            ->method('getBySymbol')
            ->with($symbol)
            ->willThrowException(new EntityNotFoundException());

        self::expectException(EntityNotFoundException::class);

        $this->mailClient->expects($this->never())
            ->method('sendEmail');

        $this->service->sendEmail($mail, $symbol, $dateFrom, $dateTo);
    }

    public function testSendEmailSuccess(): void
    {
        $mail = 'test@test.com';
        $companyName = 'GOOGLE';
        $company = $this->createMock(Company::class);
        $company->method('getName')->willReturn($companyName);
        $symbol = 'AAL';
        $dateFrom = DateTime::createFromFormat('m-d-Y', '10-16-2003');
        $dateTo = DateTime::createFromFormat('m-d-Y', '10-16-2015');

        $this->companyRepository->expects($this->once())
            ->method('getBySymbol')
            ->with($symbol)
            ->willReturn($company);

        $this->mailClient->expects($this->once())
            ->method('sendEmail')
            ->with(
                $mail,
                $companyName,
                'From 2003-10-16 to 2015-10-16'
            );

        $this->service->sendEmail($mail, $symbol, $dateFrom, $dateTo);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepository = $this->createMock(CompanyRepository::class);
        $this->mailClient = $this->createMock(MailSenderInterface::class);
        $this->service = new EmailService($this->companyRepository, $this->mailClient);
    }
}
