<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
            ['courat', '123456', ['ROLE_ADMIN']],
            ['demo1', '123456', ['ROLE_USER']],
            ['demo2', '123456', ['ROLE_TEACHER']],
            ['demo3', '123456', ['ROLE_TRANSLATOR']],
        ];
    }
}
