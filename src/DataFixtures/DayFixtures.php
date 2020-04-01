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

use App\Entity\Day;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DayFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $days = ['lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim'];

        foreach ($days as $i => $dayName) {
            $day[$i] = new Day();
            $day[$i]->setName('planning.' . $dayName);
            $manager->persist($day[$i]);
        }

        $manager->flush();
    }
}
