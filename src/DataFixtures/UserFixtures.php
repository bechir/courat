<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUsers() as [$username, $plainPassword, $roles]) {
            $user = (new User())
                ->setUsername($username)
                ->setRoles($roles);

            $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getUsers(): array
    {
        return [
            ['rim-edu', '123456', ['ROLE_ADMIN']],
            ['demo', '123456', ['ROLE_USER']],
        ];
    }
}
