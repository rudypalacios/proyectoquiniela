<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="sender")
     */
    private $invitationsSender;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="recipient")
     */
    private $invitationRecipient;

    /**
     * @ORM\OneToMany(targetEntity=League::class, mappedBy="owner")
     */
    private $leagues;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="user")
     */
    private $bets;

    public function __construct()
    {
        $this->invitationsSender = new ArrayCollection();
        $this->invitationRecipient = new ArrayCollection();
        $this->leagues = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->getName() . ' ' . $this->getLastname();
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitationsSender(): Collection
    {
        return $this->invitationsSender;
    }

    public function addInvitationsSender(Invitation $invitationsSender): self
    {
        if (!$this->invitationsSender->contains($invitationsSender)) {
            $this->invitationsSender[] = $invitationsSender;
            $invitationsSender->setSender($this);
        }

        return $this;
    }

    public function removeInvitationsSender(Invitation $invitationsSender): self
    {
        if ($this->invitationsSender->removeElement($invitationsSender)) {
            // set the owning side to null (unless already changed)
            if ($invitationsSender->getSender() === $this) {
                $invitationsSender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitationRecipient(): Collection
    {
        return $this->invitationRecipient;
    }

    public function addInvitationRecipient(Invitation $invitationRecipient): self
    {
        if (!$this->invitationRecipient->contains($invitationRecipient)) {
            $this->invitationRecipient[] = $invitationRecipient;
            $invitationRecipient->setRecipient($this);
        }

        return $this;
    }

    public function removeInvitationRecipient(Invitation $invitationRecipient): self
    {
        if ($this->invitationRecipient->removeElement($invitationRecipient)) {
            // set the owning side to null (unless already changed)
            if ($invitationRecipient->getRecipient() === $this) {
                $invitationRecipient->setRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): self
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues[] = $league;
            $league->setOwner($this);
        }

        return $this;
    }

    public function removeLeague(League $league): self
    {
        if ($this->leagues->removeElement($league)) {
            // set the owning side to null (unless already changed)
            if ($league->getOwner() === $this) {
                $league->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bet>
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setUser($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getUser() === $this) {
                $bet->setUser(null);
            }
        }

        return $this;
    }
}
