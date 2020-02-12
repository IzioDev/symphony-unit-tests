<?php


namespace App\Tests\Controllers;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserSecurityControllerTest extends WebTestCase
{
    public function testLogout()
    {
        $client = self::createClient();
        $client->followRedirects();

        $client->request("GET", "/logout");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}