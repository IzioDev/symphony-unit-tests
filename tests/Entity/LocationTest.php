<?php


namespace App\Tests\Entity;


use App\Entity\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    protected $location;
    public function setUp(): void
    {
        $this->location = new Location();
    }

    public function testShouldBeInstanceOfLocation()
    {
        $this->assertInstanceOf(Location::class, $this->location);
    }

    public function testShouldSetAName()
    {
        $this->location->setName("location");

        $this->assertSame($this->location->getName(), "location");
    }

    public function testShouldSetLat()
    {
        $this->location->setLat(1.25);

        $this->assertSame($this->location->getLat(), 1.25);
    }

    public function testShouldSetLon()
    {
        $this->location->setLon(1.33);

        $this->assertSame($this->location->getLon(), 1.33);
    }

    public function testIdShouldBeNull()
    {
        $this->assertNull($this->location->getId());
    }
}