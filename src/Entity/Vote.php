<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $pageSlug;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_votes;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_value;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="vote")
     */
    private $users;
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    


    public function getPageSlug(): ?string
    {
        return $this->pageSlug;
    }

    public function setPageSlug(string $pageSlug): self
    {
        $this->pageSlug = $pageSlug;

        return $this;
    }

    public function getTotalVotes(): ?int
    {
        return $this->total_votes;
    }

    public function setTotalVotes(int $total_votes): self
    {
        $this->total_votes = $total_votes;

        return $this;
    }

    public function getTotalValue(): ?int
    {
        return $this->total_value;
    }

    public function setTotalValue(int $total_value): self
    {
        $this->total_value = $total_value;

        return $this;
    }


    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setVote($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getVote() === $this) {
                $user->setVote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }
}
