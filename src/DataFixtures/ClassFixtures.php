<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ClassFixtures extends Fixture implements DependentFixtureInterface
{
    const SUBJECTS = ['ar', 'eng', 'maths', 'pc', 'sn', 'fr'];
    const SUBJECTS_6_AF = ['ar', 'fr'];
    const SUBJECTS_4_AS = [...self::SUBJECTS, 'hg', 'sn', 'ic', 'ir', 'fr'];
    const SUBJECTS_7 = [...self::SUBJECTS, ''];

    public function load(ObjectManager $manager)
    {
        foreach ($this->getClassDatas() as [$className, $subjectCodes]) {
            $class = new Classe();
            $class->setName($className);

            foreach ($subjectCodes as $code) {
                $subject = $manager->getRepository(Subject::class)->findOneBy(['code' => $code]);

                if ($subject) {
                    $class->addSubject($subject);
                }
            }

            $manager->persist($class);
        }

        $manager->flush();
    }

    public function getClassDatas(): array
    {
        return [
            ['6af',         self::SUBJECTS_6_AF],
            ['4as',         self::SUBJECTS_4_AS],
            ['terminaleC',  self::SUBJECTS_7],
            ['terminaleD',  self::SUBJECTS_7],
            ['terminaleLM', self::SUBJECTS_7],
            ['terminaleLO', self::SUBJECTS_7],
        ];
    }

    public function getDependencies()
    {
        return [
            SubjectFixtures::class,
        ];
    }
}
