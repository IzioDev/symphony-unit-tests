<?php

use App\Entity\Path;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected $user;
    protected $path;

    protected function setUp() : void
    {
        $this->user = new User();

        $this->path = new Path();
    }

    public function testShouldCreateAnInstanceOfUser()
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function testShouldSetAFirstName()
    {
        $this->user->setFirstName("firstname");

        $this->assertSame($this->user->getFirstName(), "firstname");
    }

    public function testShouldSetALastName()
    {
        $this->user->setLastName("lastname");

        $this->assertSame($this->user->getLastName(), "lastname");
    }

    public function testShouldSetANickName()
    {
        $this->user->setNickName("nickname");

        $this->assertSame($this->user->getNickName(), "nickname");
    }

    public function testShouldSetAnEmail()
    {
        $this->user->setEmail("email");

        $this->assertSame($this->user->getEmail(), "email");
    }

    public function testShouldSetAPassword()
    {
        $this->user->setPassword("password");

        $this->assertSame($this->user->getPassword(), "password");
    }

    public function testShouldAddAnOwnedPath()
    {
        $this->user->addOwnedPath($this->path);

        $this->assertContains($this->path, $this->user->getOwnedPaths());
    }

    public function testShouldRemoveAnOwnedPath()
    {
        $this->user->addOwnedPath($this->path);

        $this->user->removeOwnedPath($this->path);

        $this->assertNotContains($this->path, $this->user->getOwnedPaths());
    }

    public function testShouldAddAParticipatedPath()
    {
        $this->user->addParticipatedPath($this->path);

        $this->assertContains($this->path, $this->user->getParticipatedPaths());
    }

    public function testShouldRemoveAParticipatedPath()
    {
        $this->user->addParticipatedPath($this->path);

        $this->user->removeParticipatedPath($this->path);

        $this->assertNotContains($this->path, $this->user->getParticipatedPaths());
    }

    public function testToStringShouldReturnFirstName()
    {
        $this->user->setFirstName("Romain");

        $this->assertSame($this->user->__toString(), "Romain");
    }

    public function testIdShouldBeNull()
    {
        $this->assertNull($this->user->getId());
    }
}