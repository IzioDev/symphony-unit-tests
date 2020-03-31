<?php


namespace App\Tests\Controllers;


use App\Tests\FixturesWebTestCase;

class SignInControllerTest extends FixturesWebTestCase
{
    public function testShouldRedirectToHomeIfLoggedIn()
    {
        $user = $this->createUserClient();
        $user->request('GET', "/login");

        $this->assertResponseRedirects("/");
    }

    public function testShouldBeAbleToLoginWhenNotLoggedInAndUserExistInDatabase()
    {
        $client = $this->createClient();
        $client->request('GET', "/login");

        $button = $client->getCrawler()->selectButton("login_button");
        $form = $button->form([
            'nickName' => "admin",
            'password' => "password",
        ], 'POST');

        $client->submit($form, [], []);

        $this->assertResponseRedirects("/");

        $client->followRedirect();

        $this->assertSelectorNotExists('.alert-danger');
    }

    public function testShouldNotBeAbleToLoginWithAWrongPassword()
    {
        $client = $this->createClient();
        $client->request('GET', "/login");

        $button = $client->getCrawler()->selectButton("login_button");
        $form = $button->form([
            'nickName' => "admin",
            'password' => "fdsfdsfdsfsdf",
        ], 'POST');

        $client->submit($form, [], []);

        $client->followRedirect();
        $this->assertSelectorExists(".alert-danger");
    }
}