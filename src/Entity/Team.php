<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=LeagueTeam::class, mappedBy="team_1")
     */
    private $leagueTeamOne;

    /**
     * @ORM\OneToMany(targetEntity=LeagueTeam::class, mappedBy="team_2")
     */
    private $leagueTeamTwo;

    public function __construct()
    {
        $this->leagueTeamOne = new ArrayCollection();
        $this->leagueTeamTwo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, LeagueTeam>
     */
    public function getLeagueTeamOne(): Collection
    {
        return $this->leagueTeamOne;
    }

    public function addLeagueTeamOne(LeagueTeam $leagueTeamOne): self
    {
        if (!$this->leagueTeamOne->contains($leagueTeamOne)) {
            $this->leagueTeamOne[] = $leagueTeamOne;
            $leagueTeamOne->setTeam1($this);
        }

        return $this;
    }

    public function removeLeagueTeamOne(LeagueTeam $leagueTeamOne): self
    {
        if ($this->leagueTeamOne->removeElement($leagueTeamOne)) {
            // set the owning side to null (unless already changed)
            if ($leagueTeamOne->getTeam1() === $this) {
                $leagueTeamOne->setTeam1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LeagueTeam>
     */
    public function getLeagueTeamTwo(): Collection
    {
        return $this->leagueTeamTwo;
    }

    public function addLeagueTeamTwo(LeagueTeam $leagueTeamTwo): self
    {
        if (!$this->leagueTeamTwo->contains($leagueTeamTwo)) {
            $this->leagueTeamTwo[] = $leagueTeamTwo;
            $leagueTeamTwo->setTeam2($this);
        }

        return $this;
    }

    public function removeLeagueTeamTwo(LeagueTeam $leagueTeamTwo): self
    {
        if ($this->leagueTeamTwo->removeElement($leagueTeamTwo)) {
            // set the owning side to null (unless already changed)
            if ($leagueTeamTwo->getTeam2() === $this) {
                $leagueTeamTwo->setTeam2(null);
            }
        }

        return $this;
    }
}
