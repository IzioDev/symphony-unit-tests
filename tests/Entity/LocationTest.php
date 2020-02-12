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

    public function testIdShouldBeNull()
    {
        $this->assertNull($this->location->getId());
    }
}