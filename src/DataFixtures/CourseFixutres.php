<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixutres extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $classes = $manager->getRepository(Classe::class)->findAll();

        foreach (array_values($this->getCoursesData()) as [$title, $url]) {
            $course = (new Course())
                ->setTitle($title)
                ->setVideoUrl($url)
                ->addClass($classes[mt_rand(0, count($classes) - 1)]);

            $manager->persist($course);
        }
        $manager->flush();
    }

    public function getCoursesData(): array
    {
        return [
            ['Chapitre 1', 'https:/youtube.com/qwerty'],
            ['Chapitre 2', 'https:/youtube.com/qwerty'],
            ['Chapitre 3', 'https:/youtube.com/qwerty'],
            ['Chapitre 4', 'https:/youtube.com/qwerty'],
            ['Chapitre 5', 'https:/youtube.com/qwerty'],
            ['Chapitre 6', 'https:/youtube.com/qwerty'],
            ['Chapitre 7', 'https:/youtube.com/qwerty'],
            ['Chapitre 8', 'https:/youtube.com/qwerty'],
        ];
    }

    public function getDependencies()
    {
        return [
            ClassFixtures::class,
        ];
    }
}
