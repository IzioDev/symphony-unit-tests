<?php


namespace App\Tests\Controllers;


use App\Entity\Location;
use App\Entity\Path;
use App\Entity\User;
use App\Tests\FixturesWebTestCase;

class PathControllerDetailsTest extends FixturesWebTestCase
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
        $path1->setLeftSeats(4);

        $em->persist($locationStart);
        $em->persist($locationEnd);
        $em->persist($path1);
        $em->flush();
    }

    public function testShouldThrowANotFoundIfPathIdDoesntExistsInDatabase()
    {
        $client = $this->createClient();
        $client->request("GET", "/path/1/show");

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShouldDisplayPathDetailIfPathIdExistsInDatabase()
    {
        $this->setUpLyonAnnecyPath();

        $client = $this->createClient();
        $client->request("GET", "/path/1/show");

        $this->assertSelectorExists(".show-path-container");
    }
}