<?php

namespace App\Tests\Controllers;

use App\Controller\UserSecurityController;
use App\Tests\FixturesWebTestCase;
use Exception;

class UserSecurityControllerTest extends FixturesWebTestCase
{
    public function testLogout()
    {
        $client = self::createUserClient();
        $client->request("GET", "/logout");
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testLogoutThrowError()
    {
        $userSecurityController = new UserSecurityController();
        $this->expectException(Exception::class);

        $userSecurityController->logout();
    }
}