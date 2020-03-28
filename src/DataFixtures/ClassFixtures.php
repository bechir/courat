<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ClassFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getClassNames() as $className) {
            $class = (new Classe())
                ->setName($className);
            $manager->persist($class);
        }

        $manager->flush();
    }

    public function getClassNames(): array
    {
        return [
            '6af',
            '4as',
            'terminaleC',
            'terminaleD',
            'terminaleLM',
            'terminaleLO',
        ];
    }
}
