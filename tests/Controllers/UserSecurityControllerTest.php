<?php


namespace App\Tests\Controllers;


use App\Tests\FixturesWebTestCase;

class UserSecurityControllerTest extends FixturesWebTestCase
{
    public function testLogout()
    {
        $client = self::createUserClient();
        $client->request("GET", "/logout");
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}