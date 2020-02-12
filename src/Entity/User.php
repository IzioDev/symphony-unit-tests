<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(type="string", length=255)
     */
    private $nickName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="driver")
     */
    private $ownedPaths;

    public function __construct()
    {
        $this->ownedPaths = new ArrayCollection();
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
}
