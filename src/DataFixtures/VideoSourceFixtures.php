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

use App\Entity\VideoSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VideoSourceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['Facebook', 'YouTube'] as $source) {
            $videoSource = new VideoSource();
            $videoSource->setName($source);

            $manager->persist($videoSource);
        }

        $manager->flush();
    }
}
