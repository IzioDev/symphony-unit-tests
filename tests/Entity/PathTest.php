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
}