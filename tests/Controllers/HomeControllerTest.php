<?php


namespace App\Tests\Controllers;


use App\Tests\FixturesWebTestCase;

class HomeControllerTest extends FixturesWebTestCase
{
    public function testShouldGetTheHomePage()
    {
        $client = $this->createClient();
        $client->request("GET", "/");

        $this->assertResponseIsSuccessful();
    }

    public function testHomeShouldContainsALinkToLogin()
    {
        $client = $this->createClient();
        $client->request("GET", "/");

        $this->assertSelectorExists('a[href="/login"]');
    }

    public function testHomeShouldContainsALinkToRegister()
    {
        $client = $this->createClient();
        $client->request("GET", "/");

        $this->assertSelectorExists('a[href="/register"]');
    }

    public function testHomeShouldNotContainALinkToLoginIfLoggedIn()
    {
        $user = $this->createUserClient();

        $user->request("GET", "/");
        $this->assertSelectorNotExists('a[href="/login"]');
    }

    public function testHomeShouldNotContainALinkToRegisterIfLoggedIn()
    {
        $user = $this->createUserClient();
        $user->request("GET", "/");

        $this->assertSelectorNotExists('a[href="/register"]');
    }

    public function testHomeShouldContainALinkToLogoutIfLoggedIn()
    {
        $user = $this->createUserClient();
        $user->request("GET", "/");

        $this->assertSelectorExists('a[href="/logout"]');
    }

    public function testHomeShouldContainALinkToNewPathIfLoggedIn()
    {
        $user = $this->createUserClient();
        $user->request("GET", "/");

        $this->assertSelectorExists('a[href="/path/create"]');
    }

    public function testHomeShouldContainALinkToPathSearch()
    {
        $client = $this->createClient();
        $client->request("GET", "/");

        $this->assertSelectorExists('a[href="/path/search"]');
    }
}