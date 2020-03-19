<?php

namespace App\DataFixtures;

use App\Entity\ClassLevel;
use App\Entity\CourseClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CourseClassFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $level1 = $manager->getRepository(ClassLevel::class)->findOneBy(['name' => 'primaire']);
        $level2 = $manager->getRepository(ClassLevel::class)->findOneBy(['name' => 'college']);
        $level3 = $manager->getRepository(ClassLevel::class)->findOneBy(['name' => 'lycee']);
        $level4 = $manager->getRepository(ClassLevel::class)->findOneBy(['name' => 'terminale']);
        
        foreach ($this->getPrimaireClasses() as $className) {
            $class = (new CourseClass())
                ->setLevel($level1)
                ->setName($className);
            $manager->persist($class);
        }

        foreach ($this->getCollegeClassess() as $className) {
            $class = (new CourseClass())
                ->setLevel($level2)
                ->setName($className);
            $manager->persist($class);
        }

        foreach ($this->getLyceeClasses() as $className) {
            $class = (new CourseClass())
                ->setLevel($level3)
                ->setName($className);
            $manager->persist($class);
        }

        foreach ($this->getTerminaleClasses() as $className) {
            $class = (new CourseClass())
                ->setLevel($level4)
                ->setName($className);
            $manager->persist($class);
        }

        $manager->flush();
    }

    public function getPrimaireClasses(): array
    {
        return ['1af', '2af', '3af', '4af', '5af', '6af'];
    }

    public function getCollegeClassess(): array
    {
        return ['1as', '2as', '3as', '4as'];
    }

    public function getLyceeClasses(): array
    {
        return ['5c', '5d', '6c', '6d'];
    }

    public function getTerminaleClasses(): array
    {
        return [
            'TerminaleA',
            'TerminaleC',
            'TerminaleD',
            'TerminaleL',
        ];
    }

    public function getDependencies()
    {
        return [
            ClassLevelFixtures::class
        ];
    }

}
