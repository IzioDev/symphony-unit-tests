<?php


namespace App\Tests\Controllers;


use App\Entity\Location;
use App\Entity\Path;
use App\Entity\User;
use App\Tests\FixturesWebTestCase;

class PathControllerCancelTest extends FixturesWebTestCase
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

    public function testNotParticipantShouldNotBeAbleToCancelABooking()
    {
        $this->setUpLyonAnnecyPath();

        $userClient = $this->createUserClient();
        $userClient->request("GET", "/path/1/cancel");

        $this->assertResponseStatusCodeSame(403);
    }

    public function testParticipantShouldBeAbleToCancelABooking()
    {
        $this->setUpLyonAnnecyPath();

        $em = $this->em;
        $pathRespository = $em->getRepository(Path::class);
        $userRepository = $em->getRepository(User::class);

        $path = $pathRespository->findOneBy(['id' => 1]);
        $user = $userRepository->findOneBy(['nickName' => 'user']);

        $path->addPassenger($user);
        $em->persist($path);
        $em->flush();

        $userClient = $this->createUserClient();
        $userClient->request("GET", "/path/1/cancel");

        $this->assertResponseRedirects("/account");

        $userClient->followRedirect();

        $this->assertSelectorNotExists(".account-participated-path-item");
    }

    public function testDriverShouldBeAbleToCancelAPath()
    {
        $this->setUpLyonAnnecyPath();

        $admin = $this->createAdminClient();
        $admin->request("GET", "/path/1/cancel");

        $this->assertResponseRedirects("/account");

        $admin->followRedirect();

        $this->assertSelectorNotExists(".account-participated-path-item");
    }
}