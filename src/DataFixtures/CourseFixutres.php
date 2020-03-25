<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixutres extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getCoursesData(): array
    {
        return [
            'maths' => [
                ['Arithemetique - Chapitre 1', 'https:/rre.rer/ewfwef'],
                ['Arithemetique - Chapitre 2', 'https:/rre.rer/ewfwef'],
                ['Arithemetique - Chapitre 3', 'https:/rre.rer/ewfwef'],
                ['Les nombres complexes - Chapitre 1', 'https:/rre.rer/ewfwef'],
                ['Les nombres complexes - Chapitre 2', 'https:/rre.rer/ewfwef'],
            ],

            'pc' => [
                ['PC - Chapitre 1', 'https:/rre.rer/ewfwef'],
                ['PC - Chapitre 2', 'https:/rre.rer/ewfwef'],
                ['PC - Chapitre 3', 'https:/rre.rer/ewfwef'],
            ],
        ];
    }
}
