<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tutorial::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutorial;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $learner;

    /**
     * @ORM\Column(type="float")
     */
    private $score;

    /**
     * @ORM\Column(type="datetime")
     */
    private $playedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLearner(): ?User
    {
        return $this->learner;
    }

    public function setLearner(?User $learner): self
    {
        $this->learner = $learner;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getPlayedAt(): ?\DateTimeInterface
    {
        return $this->playedAt;
    }

    public function setPlayedAt(\DateTimeInterface $playedAt): self
    {
        $this->playedAt = $playedAt;

        return $this;
    }
}
