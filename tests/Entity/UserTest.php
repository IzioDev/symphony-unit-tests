<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected $user;

    protected function setUp() : void
    {
        $this->user = new User();
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
}