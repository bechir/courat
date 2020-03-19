<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getSubjectNames(): array
    {
        return ['maths', 'pc', 'hg', 'fr', 'ar', 'en', 'sn', 'ic', 'ir'];
    }
}
