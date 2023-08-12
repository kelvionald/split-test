<?php

namespace App\Repository;

use App\Entity\ExperimentValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExperimentValue>
 *
 * @method ExperimentValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExperimentValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExperimentValue[]    findAll()
 * @method ExperimentValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperimentValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperimentValue::class);
    }
}
