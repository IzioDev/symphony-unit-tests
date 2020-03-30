<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $admin = new User();
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, "password"));
        $admin->setNickName("admin");
        $admin->setEmail('admin@admin.fr');
        $admin->setFirstName('Romain');
        $admin->setLastName('Billot');
        $admin->setRoles(["ROLE_ADMIN"]);

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($admin, "password"));
        $user->setNickName("user");
        $user->setEmail('user@user.fr');
        $user->setFirstName('Romain');
        $user->setLastName('Billot');
        $user->setRoles(["ROLE_USER"]);

        $manager->persist($admin);
        $manager->persist($user);

        $manager->flush();
    }
}
