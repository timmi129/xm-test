<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Appeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class AppealRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Appeal::class);
    }

    public function save(Appeal $appeal): void
    {
        $this->_em->persist($appeal);
        $this->_em->flush();
    }
}
