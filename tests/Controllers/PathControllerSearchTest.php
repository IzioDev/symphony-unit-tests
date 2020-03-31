<?php


namespace App\Tests\Controllers;


use App\Entity\Location;
use App\Entity\Path;
use App\Entity\User;
use App\Tests\FixturesWebTestCase;

class PathControllerSearchTest extends FixturesWebTestCase
{
    public function setUpLyonAnnecyPath()
    {
        $em = $this->em;
        $userRepository = $em->getRepository(User::class);

        $nowDate = new \DateTime();
        $nowDate->add(new \DateInterval("P89D"));

        $driver = $userRepository->findOneBy(["nickName" => "admin"]);

        $locationStart = new Location();
        $locationStart->setLat(10.0);
        $locationStart->setLon(10.0);
        $locationStart->setName("Lyon");

        $locationEnd = new Location();
        $locationEnd->setLat(15.0);
        $locationEnd->setLon(15.0);
        $locationEnd->setName("Annecy");

        $path1 = new Path();
        $path1->setStartLocation($locationStart);
        $path1->setEndLocation($locationEnd);
        $path1->setDriver($driver);
        $path1->setSeats(4);
        $path1->setStartTime($nowDate);

        $em->persist($locationStart);
        $em->persist($locationEnd);
        $em->persist($path1);
        $em->flush();
    }

    public function testShouldBeAccessibleForGuests()
    {
        $client = $this->createClient();
        $client->request('GET', "/path/search");

        $this->assertResponseIsSuccessful();
    }

    public function testShouldNotifyNoPathIfThereIsNoPathInDatabase()
    {
        $client = $this->createClient();
        $client->request('GET', "/path/search");

        $this->assertSelectorTextContains(".flash-danger", "Aucun trajet ne correspond à votre recherche.");
    }

    public function testShouldDisplayPathsAfterNowDate()
    {
        $this->setUpLyonAnnecyPath();

        $client = $this->createClient();
        $client->request("GET", "/path/search");

        $this->assertSelectorNotExists(".flash-danger");
        $this->assertSelectorExists("a[href='/path/1/show']");
    }

    public function testShouldBeAbleToBookWhenConnected()
    {
        $this->setUpLyonAnnecyPath();

        $user = $this->createUserClient();
        $user->request("GET", "/path/search");

        $this->assertSelectorNotExists(".flash-danger");
        $this->assertSelectorExists("a[href='/path/1/book']");
    }

    public function testShouldNotSeePathWhenDriverIsTheSearcher()
    {
        $this->setUpLyonAnnecyPath();

        $admin = $this->createAdminClient();
        $admin->request("GET", "/path/search");

        $this->assertSelectorExists(".flash-danger");
        $this->assertSelectorNotExists("a[href='/path/1/book']");
    }

    public function testShouldNotDisplayIfSelectedDateIsGreaterThanPathDate()
    {
        $this->setUpLyonAnnecyPath();

        $client = $this->createClient();
        $client->request("GET", "/path/search");

        $nowDate = new \DateTime();
        $nowDate->add(new \DateInterval('P1Y'));
        $normalizedStringDate = $nowDate->format("Y-m-d H:i");

        $button = $client->getCrawler()->selectButton("path_search[submit]");
        $form = $button->form(["path_search[startTime]" => $normalizedStringDate], 'POST');

        $client->submit($form);

        $this->assertSelectorExists(".flash-danger");
        $this->assertSelectorNotExists("a[href='/path/1/show']");
    }

    public function testShouldNotDisplayIfSeatNumberIsGreaterThanPathSeatNumber()
    {
        $this->setUpLyonAnnecyPath();

        $client = $this->createClient();
        $client->request("GET", "/path/search");

        $button = $client->getCrawler()->selectButton("path_search[submit]");
        $form = $button->form(["path_search[seats]" => 5], 'POST');

        $client->submit($form);

        $this->assertSelectorExists(".flash-danger");
        $this->assertSelectorNotExists("a[href='/path/1/show']");
    }

    public function testShouldNotDisplayIfThereIsNoPathWithThisStartLocation()
    {
        $this->setUpLyonAnnecyPath();

        $client = $this->createClient();
        $client->request("GET", "/path/search");

        $button = $client->getCrawler()->selectButton("path_search[submit]");
        $form = $button->form(["path_search[startLocation]" => 2], 'POST');

        $client->submit($form);

        $this->assertSelectorExists(".flash-danger");
        $this->assertSelectorNotExists("a[href='/path/1/show']");
    }

    public function testShouldNotDisplayIfThereIsNoPathWithThisEndLocation()
    {
        $this->setUpLyonAnnecyPath();

        $client = $this->createClient();
        $client->request("GET", "/path/search");

        $button = $client->getCrawler()->selectButton("path_search[submit]");
        $form = $button->form(["path_search[endLocation]" => 1], 'POST');

        $client->submit($form);

        $this->assertSelectorExists(".flash-danger");
        $this->assertSelectorNotExists("a[href='/path/1/show']");
    }
}