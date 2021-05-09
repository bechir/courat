<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserRoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (UserRole::ROLES as $type) {
            $role = new UserRole();
            $role->setType($type);

            $manager->persist($role);
        }

        $manager->flush();
    }
}
