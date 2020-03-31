<?php


namespace App\Tests\Controllers;


use App\Entity\Location;
use App\Entity\Path;
use App\Entity\User;
use App\Tests\FixturesWebTestCase;

class AccountControllerTest extends FixturesWebTestCase
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

    public function testUserShouldNoSeePathInAccountIfNoBookedPath()
    {
        $this->setUpLyonAnnecyPath();

        $user = $this->createUserClient();
        $user->request("GET", "/account");

        $this->assertSelectorNotExists(".account-owned-paths-item");
        $this->assertSelectorNotExists(".account-participated-path-item");
    }

    public function testAdminShouldSeeOwnedPath()
    {
        $this->setUpLyonAnnecyPath();

        $admin = $this->createAdminClient();
        $admin->request("GET", "/account");

        $this->assertSelectorExists(".account-owned-paths-item");
        $this->assertSelectorExists("a[href='/path/1/show']");
        $this->assertSelectorNotExists(".account-participated-path-item");
    }

    public function testUserShouldSeeParticipatedPath()
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
        $userClient->request("GET", "/account");

        $this->assertSelectorNotExists(".account-owned-paths-item");
        $this->assertSelectorExists(".account-participated-path-item");
        $this->assertSelectorExists("a[href='/path/1/show']");
    }

    public function testDriverShouldBeAbleToHaveALinkToCancelHisPath()
    {
        $this->setUpLyonAnnecyPath();

        $admin = $this->createAdminClient();
        $admin->request("GET", "/account");

        $this->assertSelectorExists("a[href='/path/1/cancel']");
    }

    public function testUserShouldBeAbleToHaveALinkToCancelHisParticipatedPath()
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
        $userClient->request("GET", "/account");

        $this->assertSelectorExists("a[href='/path/1/cancel']");
    }
}