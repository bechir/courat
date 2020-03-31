<?php

namespace App\DataFixtures;

use App\Entity\Day;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DayFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        foreach ($days as $i => $dayName) 
        {
            $day[$i] = new Day();
            $day[$i]->setName($dayName);
            $manager->persist($day[$i]); 
        }



        $manager->flush();
    }
}
