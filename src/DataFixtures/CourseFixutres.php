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
                ->addClass($classes[mt_rand(0, count($classes) - 1)])
                ->addClass($classes[mt_rand(0, count($classes) - 1)])
                ->addClass($classes[mt_rand(0, count($classes) - 1)])
                ->setPublishedAt(new \DateTime());

            $manager->persist($course);
        }
        $manager->flush();
    }

    public function getCoursesData(): array
    {
        $data = [];

        for ($i = 0; $i < 50; ++$i) {
            $data[] = ["Chapitre $i", "youtube.com/2AqYr$i"];
        }

        return $data;
    }

    public function getDependencies()
    {
        return [
            ClassFixtures::class,
        ];
    }
}
