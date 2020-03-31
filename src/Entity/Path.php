<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PathRepository")
 */
class Path
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 8,
     *      minMessage = "Le nombre minimum de place est {{ limit }}",
     *      maxMessage = "Le nombre maximum de place est {{ limit }}"
     * )
     */
    private $seats;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="startPaths")
     */
    private $startLocation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="endPaths")
     */
    private $endLocation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ownedPaths")
     */
    private $driver;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="participatedPaths", cascade={"all"})
     */
    private $passengers;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getStartLocation(): ?Location
    {
        return $this->startLocation;
    }

    public function setStartLocation(?Location $startLocation): self
    {
        $this->startLocation = $startLocation;

        return $this;
    }

    public function getEndLocation(): ?Location
    {
        return $this->endLocation;
    }

    public function setEndLocation(?Location $endLocation): self
    {
        $this->endLocation = $endLocation;

        return $this;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(?User $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(User $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
        }

        return $this;
    }

    public function removePassenger(User $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
        }

        return $this;
    }
}
