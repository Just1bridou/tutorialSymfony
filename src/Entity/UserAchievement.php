<?php

namespace App\Entity;

use App\Repository\UserAchievementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAchievementRepository::class)
 */
class UserAchievement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userAchievements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Achievement::class, inversedBy="userAchievements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $achievement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAchievement(): ?Achievement
    {
        return $this->achievement;
    }

    public function setAchievement(?Achievement $achievement): self
    {
        $this->achievement = $achievement;

        return $this;
    }
}
