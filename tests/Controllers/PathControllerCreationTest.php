<?php

namespace App\Tests\Controllers;

use App\Entity\Location;
use App\Tests\FixturesWebTestCase;
use DateTime;

class PathControllerCreationTest extends FixturesWebTestCase
{
    public function testPathCreationShouldRedirectToLoginIfUserNotLoggedIn()
    {
        $client = $this->createClient();

        $client->request("GET", "/path/create");
        $this->assertResponseRedirects("/login");
    }

    public function testPathCreationShouldRedirectToLocationCreateIfNoLocationYet()
    {
        $user = $this->createUserClient();
        $user->request("GET", "/path/create");

        $this->assertResponseRedirects("/location/create");
    }

    public function testPathCreationShouldContainsALinkToLocationCreationIfThereIsAtLeastOneLocationInDatabase()
    {
        // Create a location first;
        $location = new Location();
        $location->setName("Location 1");
        $location->setLat(410.1);
        $location->setLon(350.4);

        $this->em->persist($location);
        $this->em->flush();

        $user = $this->createUserClient();
        $user->request("GET", "/path/create");

        $this->assertSelectorExists("a[href='/location/create']");
    }

    public function testPathCreationUserShouldBeAbleToCreateAPathWhenThereIsLocation()
    {
        // Create a location first;
        $location = new Location();
        $location->setName("Location 2");
        $location->setLat(410.1);
        $location->setLon(350.4);

        $this->em->persist($location);
        $this->em->flush();

        $user = $this->createUserClient();
        $user->request("GET", "/path/create");

        $nowDate = new \DateTime();

        // Fill form
        $button = $user->getCrawler()->selectButton('path[submit]');
        $form = $button->form(['path[seats]' => 2, 'path[startTime]' => $nowDate->format("Y-m-d H:i"), 'path[startLocation]' => $location->getId(), 'path[endLocation]' => $location->getId()], 'POST');
        // Submit it
        $user->submit($form, [], []);

        // If there is a success message, we're good
        $this->assertSelectorExists(".flash-success");
    }

    public function testPathCreationUserShouldNotBeAbleToCreateAPathWhenSeatIsEqualToZero()
    {
        // Create a location first;
        $location = new Location();
        $location->setName("Location 2");
        $location->setLat(410.1);
        $location->setLon(350.4);

        $this->em->persist($location);
        $this->em->flush();

        $user = $this->createUserClient();
        $user->request("GET", "/path/create");

        $nowDate = new \DateTime();

        // Fill form
        $button = $user->getCrawler()->selectButton('path[submit]');
        $form = $button->form(['path[seats]' => 0, 'path[startTime]' => $nowDate->format("Y-m-d H:i"), 'path[startLocation]' => $location->getId(), 'path[endLocation]' => $location->getId()], 'POST');
        // Submit it
        $user->submit($form, [], []);

        $this->assertSelectorNotExists(".flash-success");
    }

    public function testPathCreationUserShouldNotBeAbleToCreateAPathWhenSeatIsGreaterThanHeight()
    {
        // Create a location first;
        $location = new Location();
        $location->setName("Location 2");
        $location->setLat(410.1);
        $location->setLon(350.4);

        $this->em->persist($location);
        $this->em->flush();

        $user = $this->createUserClient();
        $user->request("GET", "/path/create");

        $nowDate = new \DateTime();

        // Fill form
        $button = $user->getCrawler()->selectButton('path[submit]');
        $form = $button->form(['path[seats]' => 9, 'path[startTime]' => $nowDate->format("Y-m-d H:i"), 'path[startLocation]' => $location->getId(), 'path[endLocation]' => $location->getId()], 'POST');
        // Submit it
        $user->submit($form, [], []);

        $this->assertSelectorNotExists(".flash-success");
    }

    public function testPathCreationShouldContainsALinkToHomeIfThereIsAtLeastOneLocation()
    {
        // Create a location first;
        $location = new Location();
        $location->setName("Location 1");
        $location->setLat(410.1);
        $location->setLon(350.4);

        $this->em->persist($location);
        $this->em->flush();

        $user = $this->createUserClient();
        $user->request("GET", "/path/create");

        $this->assertSelectorExists("a[href='/']");
    }
}