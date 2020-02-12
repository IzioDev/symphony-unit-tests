<?php


namespace App\Tests\Controllers;


use App\Tests\FixturesWebTestCase;

class UserSecurityControllerTest extends FixturesWebTestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);
    }

    public function testLogout()
    {
        $this->client->followRedirects();
        $this->client->request("GET", "/logout");
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}