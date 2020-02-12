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
}