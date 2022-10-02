<?php

namespace App\Entity;

use App\Repository\LeagueTeamRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LeagueTeamRepository::class)
 */
class LeagueTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=league::class, inversedBy="leagueTeams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity=team::class, inversedBy="leagueTeamOne")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team_1;

    /**
     * @ORM\ManyToOne(targetEntity=team::class, inversedBy="leagueTeamTwo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team_2;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTeam1(): ?team
    {
        return $this->team_1;
    }

    public function setTeam1(?team $team_1): self
    {
        $this->team_1 = $team_1;

        return $this;
    }

    public function getTeam2(): ?team
    {
        return $this->team_2;
    }

    public function setTeam2(?team $team_2): self
    {
        $this->team_2 = $team_2;

        return $this;
    }
}
