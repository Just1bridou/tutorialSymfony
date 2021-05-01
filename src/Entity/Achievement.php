<?php

namespace App\Entity;

use App\Repository\AchievementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AchievementRepository::class)
 */
class Achievement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $targetField;

    /**
     * @ORM\Column(type="MathematicalOperatorEnum")
     */
    private $mathematicalOperator;

    /**
     * @ORM\Column(type="float")
     */
    private $goal;

    /**
     * @ORM\OneToMany(targetEntity=UserAchievement::class, mappedBy="achievement")
     */
    private $userAchievements;

    public function __construct()
    {
        $this->userAchievements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTargetField(): ?string
    {
        return $this->targetField;
    }

    public function setTargetField(string $targetField): self
    {
        $this->targetField = $targetField;

        return $this;
    }

    public function getMathematicalOperator()
    {
        return $this->mathematicalOperator;
    }

    public function setMathematicalOperator($mathematicalOperator): self
    {
        $this->mathematicalOperator = $mathematicalOperator;

        return $this;
    }

    public function getGoal(): ?float
    {
        return $this->goal;
    }

    public function setGoal(float $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * @return Collection|UserAchievement[]
     */
    public function getUserAchievements(): Collection
    {
        return $this->userAchievements;
    }

    public function addUserAchievement(UserAchievement $userAchievement): self
    {
        if (!$this->userAchievements->contains($userAchievement)) {
            $this->userAchievements[] = $userAchievement;
            $userAchievement->setAchievement($this);
        }

        return $this;
    }

    public function removeUserAchievement(UserAchievement $userAchievement): self
    {
        if ($this->userAchievements->removeElement($userAchievement)) {
            // set the owning side to null (unless already changed)
            if ($userAchievement->getAchievement() === $this) {
                $userAchievement->setAchievement(null);
            }
        }

        return $this;
    }
    
    /**
     * toString function
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->getTargetField() . "  " . $this->getMathematicalOperator() . " " . $this->getGoal();
    }
}
