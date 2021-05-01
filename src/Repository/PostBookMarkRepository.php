<?php

namespace App\Repository;

use App\Entity\PostBookMark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostBookMark|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostBookMark|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostBookMark[]    findAll()
 * @method PostBookMark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostBookMarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostBookMark::class);
    }

    // /**
    //  * @return PostBookMark[] Returns an array of PostBookMark objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostBookMark
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
