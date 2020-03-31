<?php


namespace App\Tests\Entity;


use App\Entity\Location;
use App\Entity\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    protected $path;
    protected $location1;
    protected $location2;

    public function setUp(): void
    {
        $this->path = new Path();

        $this->location1 = new Location();
        $this->location1->setName("Lyon");
        $this->location1->setLon(10.0);
        $this->location1->setLat(10.0);

        $this->location2 = new Location();
        $this->location2->setName("Annecy");
        $this->location2->setLon(10.0);
        $this->location2->setLat(10.0);
    }

    public function testShouldBeInstanceOfPath()
    {
        $this->assertInstanceOf(Path::class, $this->path);
    }

    public function testShouldSetSeats()
    {
        $this->path->setSeats(4);

        $this->assertSame($this->path->getSeats(), 4);
    }

    public function testShouldSetStartTime()
    {
        $dateTime = new \DateTime();
        $this->path->setStartTime($dateTime);

        $this->assertSame($this->path->getStartTime(), $dateTime);
    }

    public function testShouldSetStartLocation()
    {
        $this->path->setStartLocation($this->location1);

        $this->assertSame($this->path->getStartLocation(), $this->location1);
    }

    public function testShouldSetEndLocation()
    {
        $this->path->setEndLocation($this->location2);

        $this->assertSame($this->path->getEndLocation(), $this->location2);
    }

    public function testShould()
    {
        $this->path->setLeftSeats(4);

        $this->assertSame($this->path->getLeftSeats(), 4);
    }

    public function testIdShouldBeNull()
    {
        $this->assertNull($this->path->getId());
    }
}