<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
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
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\Column(type="float")
     */
    private $lon;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="startLocation")
     */
    private $startPaths;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="endLocation")
     */
    private $endPaths;

    public function __construct()
    {
        $this->startPaths = new ArrayCollection();
        $this->endPaths = new ArrayCollection();
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

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getStartPaths(): Collection
    {
        return $this->startPaths;
    }

    public function addStartPath(Path $startPath): self
    {
        if (!$this->startPaths->contains($startPath)) {
            $this->startPaths[] = $startPath;
            $startPath->setStartLocation($this);
        }

        return $this;
    }

    public function removeStartPath(Path $startPath): self
    {
        if ($this->startPaths->contains($startPath)) {
            $this->startPaths->removeElement($startPath);
            // set the owning side to null (unless already changed)
            if ($startPath->getStartLocation() === $this) {
                $startPath->setStartLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getEndPaths(): Collection
    {
        return $this->endPaths;
    }

    public function addEndPath(Path $endPath): self
    {
        if (!$this->endPaths->contains($endPath)) {
            $this->endPaths[] = $endPath;
            $endPath->setEndLocation($this);
        }

        return $this;
    }

    public function removeEndPath(Path $endPath): self
    {
        if ($this->endPaths->contains($endPath)) {
            $this->endPaths->removeElement($endPath);
            // set the owning side to null (unless already changed)
            if ($endPath->getEndLocation() === $this) {
                $endPath->setEndLocation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
