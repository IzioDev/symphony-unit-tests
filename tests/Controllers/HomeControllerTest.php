<?php


namespace App\Tests\Controllers;


use App\Tests\FixturesWebTestCase;

class HomeControllerTest extends FixturesWebTestCase
{
    public function testShouldGetTheHomePage()
    {
        parent::$client->request("GET", "/");
        $this->assertResponseIsSuccessful();
    }

    public function testHomeShouldContainsALinkToLogin()
    {
        parent::$client->request("GET", "/");

        $this->assertSelectorExists('a[href="/login"]');
    }

    public function testHomeShouldContainsALinkToRegister()
    {
        parent::$client->request("GET", "/");

        $this->assertSelectorExists('a[href="/register"]');
    }

    public function testHomeShouldNotContainALinkToLoginIfLoggedIn()
    {
        parent::$user->request("GET", "/");

        $this->assertSelectorNotExists('a[href="/login"]');
    }

    public function testHomeShouldNotContainALinkToRegisterIfLoggedIn()
    {
        parent::$user->request("GET", "/");

        $this->assertSelectorNotExists('a[href="/register"]');
    }

    public function testHomeShouldContainALinkToLogoutIfLoggedIn()
    {
        parent::$user->request("GET", "/");

        $this->assertSelectorExists('a[href="/logout"]');
    }

    public function testHomeShouldContainALinkToNewPathIfLoggedIn()
    {
        parent::$user->request("GET", "/");

        $this->assertSelectorExists('a[href="/path/create"]');
    }

    public function testHomeShouldContainALinkToPathSearch()
    {
        parent::$client->request("GET", "/");

        $this->assertSelectorExists('a[href="/path/search"]');
    }
}