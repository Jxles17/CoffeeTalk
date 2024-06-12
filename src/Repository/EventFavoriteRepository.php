<?php

namespace App\Repository;

use App\Entity\EventFavorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventFavorite>
 *
 * @method EventFavorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventFavorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventFavorite[]    findAll()
 * @method EventFavorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventFavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventFavorite::class);
    }

    //    /**
    //     * @return EventFavorite[] Returns an array of EventFavorite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EventFavorite
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
