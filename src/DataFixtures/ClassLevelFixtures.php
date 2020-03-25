<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use App\Entity\ClassLevel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ClassLevelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getLevels() as $name) {
            $level = (new ClassLevel())
                ->setName($name);
            $manager->persist($level);
        }

        $manager->flush();
    }

    public function getLevels(): array
    {
        return ['primaire', 'college', 'lycee', 'terminale'];
    }
}
