<?php

namespace App\Entity;

use App\Repository\LeagueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LeagueRepository::class)
 */
class League
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $pool;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $expiration_date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="leagues")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=LeagueMember::class, mappedBy="league")
     */
    private $leagueMembers;

    /**
     * @ORM\OneToMany(targetEntity=LeagueTeam::class, mappedBy="league")
     */
    private $leagueTeams;

    public function __construct()
    {
        $this->leagueMembers = new ArrayCollection();
        $this->leagueTeams = new ArrayCollection();
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

    public function getPool(): ?float
    {
        return $this->pool;
    }

    public function setPool(float $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeImmutable $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeImmutable
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeImmutable $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, LeagueMember>
     */
    public function getLeagueMembers(): Collection
    {
        return $this->leagueMembers;
    }

    public function addLeagueMember(LeagueMember $leagueMember): self
    {
        if (!$this->leagueMembers->contains($leagueMember)) {
            $this->leagueMembers[] = $leagueMember;
            $leagueMember->setLeague($this);
        }

        return $this;
    }

    public function removeLeagueMember(LeagueMember $leagueMember): self
    {
        if ($this->leagueMembers->removeElement($leagueMember)) {
            // set the owning side to null (unless already changed)
            if ($leagueMember->getLeague() === $this) {
                $leagueMember->setLeague(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LeagueTeam>
     */
    public function getLeagueTeams(): Collection
    {
        return $this->leagueTeams;
    }

    public function addLeagueTeam(LeagueTeam $leagueTeam): self
    {
        if (!$this->leagueTeams->contains($leagueTeam)) {
            $this->leagueTeams[] = $leagueTeam;
            $leagueTeam->setLeague($this);
        }

        return $this;
    }

    public function removeLeagueTeam(LeagueTeam $leagueTeam): self
    {
        if ($this->leagueTeams->removeElement($leagueTeam)) {
            // set the owning side to null (unless already changed)
            if ($leagueTeam->getLeague() === $this) {
                $leagueTeam->setLeague(null);
            }
        }

        return $this;
    }
}
