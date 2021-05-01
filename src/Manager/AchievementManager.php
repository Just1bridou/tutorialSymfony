<?php

namespace App\Manager;

use App\Entity\User;
use App\Entity\UserAchievement;
use App\Repository\AchievementRepository;
use App\Repository\TutorialRepository;
use App\Repository\UserAchievementRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AchievementManager
 * @package App\Manager
 */
class AchievementManager
{
    const TUTORIAL_COUNT = "tutorial_count";

    /**
     * AchievementManager constructor.
     * 
     * @param TutorialRepository            $tutorialRepository
     * @param UserAchievementRepository     $userAchievementRepository
     * @param AchievementRepository         $achievementRepository
     * @param EntityManagerInterface        $entityManagerInterface
     * 
     */
    public function __construct(TutorialRepository $tutorialRepository, UserAchievementRepository $userAchievementRepository, AchievementRepository $achievementRepository, EntityManagerInterface $entityManagerInterface)
    {
        $this->tutorialRepository = $tutorialRepository;
        $this->userAchievementRepository = $userAchievementRepository;
        $this->achievementRepository = $achievementRepository;
        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function checkAchievement(User $user, string $key): bool
    {
        if (!in_array($key, [self::TUTORIAL_COUNT])) {
            return false;
        }

        switch ($key) {
            case self::TUTORIAL_COUNT:
                return $this->tutorialCount($user, $this->getNextTutorialCountGoal($user));
        }

        return false;
    }

    /**
     * Find next achievement value for "TutorialCountAchievement", return null if there is no more goal in this kind of achievement
     * 
     * @param User $user
     * 
     * @return float|null
     */
    private function getNextTutorialCountGoal(User $user): ?float
    {
        $currentGoal = $this->userAchievementRepository->findMaxTutorialCountAchievement($user, self::TUTORIAL_COUNT)[0]['max_goal'];

        //do not have achievement done
        if ($currentGoal == null) {
            return $this->achievementRepository->findMinTutorialCountAchievement(self::TUTORIAL_COUNT)[0]['min_goal'];; //this user don't have achievement done for this kind of achievement, give it the smallest one as goal
        }

        $nextGoal = $this->userAchievementRepository->findNextTutorialCountAchievement($user, self::TUTORIAL_COUNT, $currentGoal)[0]['next_goal'];

        dd($nextGoal);
        return $nextGoal; //if null, it means he doest not have higher achievement to reach
    }

    /**
     * Check if the user reached the goal, and save it if it is
     * 
     * @param User  $user
     * @param float $goal
     * 
     * @return bool
     */
    private function tutorialCount(User $user, ?float $goal): bool
    {
        if ($goal === null) {
            return false;
        }

        if (count($this->tutorialRepository->findBy(["author" => $user])) >= $goal) {
            $userAchievement = new UserAchievement();
            $userAchievement->setUser($user);
            $userAchievement->setAchievement($this->achievementRepository->findOneBy(["targetField" => self::TUTORIAL_COUNT, "goal" => $goal]));

            $this->entityManagerInterface->persist($userAchievement);
            $this->entityManagerInterface->flush();

            return true;
        }

        return false;
    }
}