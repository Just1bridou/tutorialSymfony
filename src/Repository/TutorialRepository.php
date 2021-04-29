<?php

namespace App\Repository;

use App\Entity\Tutorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tutorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tutorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tutorial[]    findAll()
 * @method Tutorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tutorial::class);
    }

    public function tenLastsTutorials(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function searchTutorial($keyword): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.title LIKE :key')
            ->setParameter('key' , '%'.$keyword.'%')
            ->getQuery()
            ->getResult();
    }

    public function selectTutorialWithQuizz($id): array {
        return $this->createQueryBuilder('t')
            ->select('t,q,a')
            ->leftJoin('t.questions', 'q')
            ->leftJoin('q.answers', 'a')
            ->where('t.id = ' . $id)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Tutorial[] Returns an array of Tutorial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tutorial
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
