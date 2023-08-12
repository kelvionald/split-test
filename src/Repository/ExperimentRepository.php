<?php

namespace App\Repository;

use App\Entity\Experiment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Experiment>
 *
 * @method Experiment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Experiment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Experiment[]    findAll()
 * @method Experiment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experiment::class);
    }
}
