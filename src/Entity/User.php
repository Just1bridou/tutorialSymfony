<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\OneToMany(targetEntity=Tutorial::class, mappedBy="author")
     */
    private $tutorials;

    /**
     * @ORM\OneToMany(targetEntity=Score::class, mappedBy="learner")
     */
    private $scores;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="learner")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=Bookmark::class, mappedBy="learner", orphanRemoval=true)
     */
    private $bookmarks;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBanned;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author")
     */
    private $comments;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="float")
     */
    private $Wallet = 0;

    /**
     * @ORM\OneToMany(targetEntity=PostLike::class, mappedBy="user")
     */
    private $seeLikes;

    /**
     * @ORM\OneToMany(targetEntity=PostBookMark::class, mappedBy="user")
     */

    private $seeBookMarks;
     /**
     * @ORM\OneToMany(targetEntity=UserAchievement::class, mappedBy="user")
     */
    private $userAchievements;

    public function __construct()
    {
        $this->tutorials = new ArrayCollection();
        $this->scores = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->bookmarks = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->seeLikes = new ArrayCollection();
        $this->seeBookMarks = new ArrayCollection();
        $this->userAchievements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|Tutorial[]
     */
    public function getTutorials(): Collection
    {
        return $this->tutorials;
    }

    public function addTutorial(Tutorial $tutorial): self
    {
        if (!$this->tutorials->contains($tutorial)) {
            $this->tutorials[] = $tutorial;
            $tutorial->setAuthor($this);
        }

        return $this;
    }

    public function removeTutorial(Tutorial $tutorial): self
    {
        if ($this->tutorials->removeElement($tutorial)) {
            // set the owning side to null (unless already changed)
            if ($tutorial->getAuthor() === $this) {
                $tutorial->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Score[]
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Score $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setLearner($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getLearner() === $this) {
                $score->setLearner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setLearner($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getLearner() === $this) {
                $like->setLearner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bookmark[]
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): self
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks[] = $bookmark;
            $bookmark->setLearner($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            // set the owning side to null (unless already changed)
            if ($bookmark->getLearner() === $this) {
                $bookmark->setLearner(null);
            }
        }

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    public function getRoles(): ?array
    {
        return array_merge(["ROLE_USER"], $this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials() {}
    public function getSalt() {}

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getWallet(): ?float
    {
        return $this->Wallet;
    }

    public function setWallet(float $Wallet): self
    {
        $this->Wallet = $Wallet;

        return $this;
    }

    /**
     * @return Collection|PostLike[]
     */
    public function getSeeLikes(): Collection
    {
        return $this->seeLikes;
    }

    public function addSeeLike(PostLike $seeLike): self
    {
        if (!$this->seeLikes->contains($seeLike)) {
            $this->seeLikes[] = $seeLike;
            $seeLike->setUser($this);
        }

        return $this;
    }

    public function removeSeeLike(PostLike $seeLike): self
    {
        if ($this->seeLikes->removeElement($seeLike)) {
            // set the owning side to null (unless already changed)
            if ($seeLike->getUser() === $this) {
                $seeLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PostBookMark[]
     */
    public function getSeeBookMarks(): Collection
    {
        return $this->seeBookMarks;
    }

    public function addSeeBookMark(PostBookMark $seeBookMark): self
    {
        if (!$this->seeBookMarks->contains($seeBookMark)) {
            $this->seeBookMarks[] = $seeBookMark;
            $seeBookMark->setUser($this);
        }
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
            $userAchievement->setUser($this);
        }

        return $this;
    }

    public function removeSeeBookMark(PostBookMark $seeBookMark): self
    {
        if ($this->seeBookMarks->removeElement($seeBookMark)) {
            // set the owning side to null (unless already changed)
            if ($seeBookMark->getUser() === $this) {
                $seeBookMark->setUser(null);

            }
        }
        return $this;
    }

    public function removeUserAchievement(UserAchievement $userAchievement): self
    {
        if ($this->userAchievements->removeElement($userAchievement)) {
            // set the owning side to null (unless already changed)
            if ($userAchievement->getUser() === $this) {
                $userAchievement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Permet de savoir si un user a "bokkmark??" un tuto
     * 
     * @param BookMark $bookmark
     * @return boolean
     */
    public function getBookMarkUser(BookMark $bookmark) : bool
    {
        foreach ($this->isBookmarked as $bookmark){
            if ($bookmark->getIsBookmarked() === $bookmark) return true;
        }
        return false;
    }

}
