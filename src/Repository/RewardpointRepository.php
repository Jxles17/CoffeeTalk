<?php

namespace App\Repository;

use App\Entity\Rewardpoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rewardpoint>
 *
 * @method Rewardpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rewardpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rewardpoint[]    findAll()
 * @method Rewardpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardpointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rewardpoint::class);
    }

    //    /**
    //     * @return Rewardpoint[] Returns an array of Rewardpoint objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Rewardpoint
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
