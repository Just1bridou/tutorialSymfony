<?php

namespace App\Entity;

use App\Repository\BookmarkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookmarkRepository::class)
 */
class Bookmark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookmarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $learner;

    /**
     * @ORM\ManyToOne(targetEntity=Tutorial::class, inversedBy="bookmarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutorial;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBookmarked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLearner(): ?User
    {
        return $this->learner;
    }

    public function setLearner(?User $learner): self
    {
        $this->learner = $learner;

        return $this;
    }

    public function getTutorial(): ?Tutorial
    {
        return $this->tutorial;
    }

    public function setTutorial(?Tutorial $tutorial): self
    {
        $this->tutorial = $tutorial;

        return $this;
    }

    public function getIsBookmarked(): ?bool
    {
        return $this->isBookmarked;
    }

    public function setIsBookmarked(bool $isBookmarked): self
    {
        $this->isBookmarked = $isBookmarked;

        return $this;
    }

    
}
