<?php

namespace App\Entity;

use App\Repository\LeagueMemberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LeagueMemberRepository::class)
 */
class LeagueMember
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
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=league::class, inversedBy="leagueMembers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLeague(): ?league
    {
        return $this->league;
    }

    public function setLeague(?league $league): self
    {
        $this->league = $league;

        return $this;
    }
}
