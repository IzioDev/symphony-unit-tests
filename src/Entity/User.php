<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nickName;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="driver")
     */
    private $ownedPaths;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Path", mappedBy="passengers")
     */
    private $participatedPaths;

    public function __construct()
    {
        $this->ownedPaths = new ArrayCollection();
        $this->participatedPaths = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

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

    /**
     * @return Collection|Path[]
     */
    public function getOwnedPaths(): Collection
    {
        return $this->ownedPaths;
    }

    public function addOwnedPath(Path $ownedPath): self
    {
        if (!$this->ownedPaths->contains($ownedPath)) {
            $this->ownedPaths[] = $ownedPath;
            $ownedPath->setDriver($this);
        }

        return $this;
    }

    public function removeOwnedPath(Path $ownedPath): self
    {
        if ($this->ownedPaths->contains($ownedPath)) {
            $this->ownedPaths->removeElement($ownedPath);
            // set the owning side to null (unless already changed)
            if ($ownedPath->getDriver() === $this) {
                $ownedPath->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getParticipatedPaths(): Collection
    {
        return $this->participatedPaths;
    }

    public function addParticipatedPath(Path $participatedPath): self
    {
        if (!$this->participatedPaths->contains($participatedPath)) {
            $this->participatedPaths[] = $participatedPath;
            $participatedPath->addPassenger($this);
        }

        return $this;
    }

    public function removeParticipatedPath(Path $participatedPath): self
    {
        if ($this->participatedPaths->contains($participatedPath)) {
            $this->participatedPaths->removeElement($participatedPath);
            $participatedPath->removePassenger($this);
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->nickName;
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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
