<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $companiesData = json_decode(file_get_contents('companies.json', true), true);

        $i = 0;

        foreach ($companiesData as $companyData) {
            $company = new Company(
                $companyData['Company Name'],
                $companyData['Financial Status'],
                $companyData['Market Category'],
                $companyData['Round Lot Size'],
                $companyData['Security Name'],
                $companyData['Symbol'],
                $companyData['Test Issue'],
            );

            $manager->persist($company);
            ++$i;

            if ($i % 200 === 0) {
                $manager->flush();
            }
        }
    }
}
