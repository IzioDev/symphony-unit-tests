<?php


namespace App\Tests\Controllers;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testShouldGetTheHomePage()
    {
        $client = self::createClient();

        $client->request("GET", "/");

        $this->assertResponseIsSuccessful();
    }

    public function testHomeShouldContainsALinkToLogin()
    {
        $client = self::createClient();

        $client->request("GET", "/");

        $this->assertSelectorExists('a[href="/login"]');
    }

    public function testHomeShouldContainsALinkToRegister()
    {
        $client = self::createClient();

        $client->request("GET", "/");

        $this->assertSelectorExists('a[href="/register"]');
    }

    public function testHomeShouldNotContainALinkToLoginIfLoggedIn()
    {
        $authClient = self::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $authClient->request("GET", "/");

        $this->assertSelectorNotExists('a[href="/login"]');
    }

    public function testHomeShouldNotContainALinkToRegisterIfLoggedIn()
    {
        $authClient = self::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $authClient->request("GET", "/");

        $this->assertSelectorNotExists('a[href="/register"]');
    }

    public function testHomeShouldContainALinkToLogoutIfLoggedIn()
    {
        $authClient = self::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $authClient->request("GET", "/");

        $this->assertSelectorExists('a[href="/logout"]');
    }
}