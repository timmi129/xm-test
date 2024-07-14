<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Company::class);
    }

    public function save(Company $appeal): void
    {
        $this->_em->persist($appeal);
        $this->_em->flush();
    }

    public function findBySymbol(string $symbol): ?Company
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.symbol = :symbol')
            ->setParameter('symbol', $symbol)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getBySymbol(string $symbol): Company
    {
        $company = $this->findBySymbol($symbol);

        if (null === $company) {
            throw new EntityNotFoundException();
        }

        return $company;
    }
}
