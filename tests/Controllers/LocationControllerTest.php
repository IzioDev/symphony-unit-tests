<?php

namespace App\Tests\Controllers;

use App\Entity\Location;
use App\Tests\FixturesWebTestCase;

class LocationControllerTest extends FixturesWebTestCase
{
    public function testLocationCreationShouldHaveALinkToHomePage()
    {
        $user = $this->createUserClient();
        $user->request('GET', '/location/create');

        $this->assertSelectorExists('a[href="/"]');
    }

    public function testLocationCreateShouldPersistToDatabase()
    {
        $user = $this->createUserClient();
        $user->request('GET', '/location/create');

        $button = $user->getCrawler()->selectButton('location_form[submit]');
        $form = $button->form([
        'location_form[name]' => "Grenoble",
        'location_form[lat]' => 101.5,
        'location_form[lon]' => 101.5,
    ], 'POST');
        // Submit it
        $user->submit($form, [], []);

        $this->assertSelectorExists(".flash-success");

        $em = $this->em;
        $locationRepository = $em->getRepository(Location::class);
        $grenobleLocation = $locationRepository->findOneBy(["name" => "Grenoble"]);

        $this->assertNotEmpty($grenobleLocation);
    }
}