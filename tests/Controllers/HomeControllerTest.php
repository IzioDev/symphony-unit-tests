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
        $this->assertSelectorTextContains("p", "Bonjour les copains");
    }
}