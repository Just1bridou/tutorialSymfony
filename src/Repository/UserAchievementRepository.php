<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAchievement|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAchievement|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAchievement[]    findAll()
 * @method UserAchievement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAchievementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAchievement::class);
    }

    public function findMaxTutorialCountAchievement(User $user, string $targetField): array
    {
        return $this->createQueryBuilder('u')
            ->select('u, MAX(a.goal) AS max_goal')
            ->join('u.achievement', 'a')
            ->where('u.user = :user')
            ->andWhere('a.targetField = :targetField')
            ->setParameter('user', $user)
            ->setParameter('targetField', $targetField)
            ->getQuery()
            ->getResult();
    }

    public function findNextTutorialCountAchievement(User $user, string $targetField, float $currentGoal): array
    {
        $qb = $this->createQueryBuilder('u');

        //tous les id de UserAchievement
        $nots = $qb->select('u.achievement')
                    ->getQuery()
                    ->getResult();
        
        //goal mini que l'user a d'une certaine catégorie, dont l'id du succès n'est pas l'id de l'userAchievement
        $linked = $qb->select('MIN(a.goal) AS next_goal')
                    ->join('u.achievement', 'a')
                    ->where('u.user = :user')
                    ->andWhere('a.targetField = :targetField')
                    ->where($qb->expr()->notIn('a.id', ':subQuery'))
                    ->setParameter('subQuery', $nots)
                    ->getQuery()
                    ->getResult();

        return $linked;
    }

    public function findByAchievementTargetField(User $user, string $targetField): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.achievement', 'a')
            ->where('u.user = :user')
            ->andWhere('a.targetField = :targetField')
            ->setParameter('user', $user)
            ->setParameter('targetField', $targetField)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return UserAchievement[] Returns an array of UserAchievement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAchievement
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
