<?php

namespace App\Entity;

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
}
