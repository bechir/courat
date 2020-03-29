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

use App\Entity\Classe;
use App\Entity\Course;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixutres extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $classes = $manager->getRepository(Classe::class)->findAll();
        $subjects = $manager->getRepository(Subject::class)->findAll();

        foreach (array_values($this->getCoursesData()) as [$title, $url]) {
            $course = (new Course())
                ->setTitle($title)
                ->setVideoUrl($url)
                ->setSubject($subjects[mt_rand(0, count($subjects) - 1)])
                ->setPublishedAt(new \DateTime());

            $classes[mt_rand(0, count($classes) - 1)]->addCourse($course);

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
            SubjectFixtures::class,
        ];
    }
}
