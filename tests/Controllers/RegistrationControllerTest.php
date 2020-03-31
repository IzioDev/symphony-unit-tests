<?php


namespace App\Tests\Controllers;


use App\Entity\User;
use App\Tests\FixturesWebTestCase;

class RegistrationControllerTest extends FixturesWebTestCase
{
    public function testAuthUserShouldBeRedirectedToHomePage()
    {
        $user = $this->createUserClient();
        $user->request('GET', "/register");

        $this->assertResponseRedirects("/");
    }

    public function testGuestUserShouldBeAbleToCreateAnAccountAndHaveUserRole()
    {
        $client = $this->createClient();
        $client->request('GET', "/register");

        $button = $client->getCrawler()->selectButton("registration_form[submit]");

        $form = $button->form([
            'registration_form[nickName]' => "Utilisateur",
            'registration_form[firstName]' => "Jean",
            'registration_form[lastName]' => "Dohn",
            'registration_form[email]' => "test@utilisateur.fr",
            'registration_form[plainPassword]' => "password",
            'registration_form[agreeTerms]' => '1'
        ], 'POST');

        $client->submit($form, [], []);

        $this->assertResponseRedirects("/");

        $client->followRedirect();

        $this->assertSelectorExists(".flash-success");

        $em = $this->em;
        $userRespository = $em->getRepository(User::class);
        $utilisateur = $userRespository->findOneBy(["nickName" => "Utilisateur"]);

        $this->assertNotEmpty($utilisateur);
        $this->assertContains("ROLE_USER", $utilisateur->getRoles());
    }
}