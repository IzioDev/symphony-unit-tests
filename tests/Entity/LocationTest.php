<?php


namespace App\Tests\Entity;


use App\Entity\Location;
use PHPUnit\Framework\TestCase;
use App\Entity\Path;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class LocationTest extends TestCase
{
    protected $location;
    protected $path;
    public function setUp(): void
    {
        $this->location = new Location();
        $this->path = new Path();
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
    
    public function testShouldSetStartPaths() {
        $this->assertInstanceOf(ArrayCollection::class, $this->location->getStartPaths());
    }
        
    public function testShouldAddStartPath() {
        $this->location->addStartPath($this->path);
        
        $this->assertNotEmpty($this->location->getStartPaths());
    }
    
    public function testShouldRemoveStartPath() {
        $this->location->addStartPath($this->path);
        
        $this->location->removeStartPath($this->path);
        
        $this->assertEmpty($this->location->getStartPaths());
    }

    public function testShouldSetEndPaths() {
        $this->assertInstanceOf(ArrayCollection::class, $this->location->getEndPaths());
    }
    
    public function testShouldAddEndPath() {
        $this->location->addEndPath($this->path);
        
        $this->assertNotEmpty($this->location->getEndPaths());
    }
    
    public function testShouldRemoveEndPath() {
        $this->location->addEndPath($this->path);
        
        $this->location->removeEndPath($this->path);
        
        $this->assertEmpty($this->location->getEndPaths());
    }
}