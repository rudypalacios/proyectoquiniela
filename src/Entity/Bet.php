<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score_1;

    /**
     * @ORM\Column(type="integer")
     */
    private $score_2;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore1(): ?int
    {
        return $this->score_1;
    }

    public function setScore1(int $score_1): self
    {
        $this->score_1 = $score_1;

        return $this;
    }

    public function getScore2(): ?int
    {
        return $this->score_2;
    }

    public function setScore2(int $score_2): self
    {
        $this->score_2 = $score_2;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
