<?php


namespace App\Tests\Entity;


use App\Entity\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    protected $path;

    public function setUp(): void
    {
        $this->path = new Path();
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

    public function testIdShouldBeNull()
    {
        $this->assertNull($this->path->getId());
    }
}