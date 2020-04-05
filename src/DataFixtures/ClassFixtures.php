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
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ClassFixtures extends Fixture implements DependentFixtureInterface
{
    const SUBJECTS_6_AF = ['ar', 'fr', 'maths', 'ir'];
    const SUBJECTS_4_AS = ['ir', 'fr', 'ar', 'maths'];
    const SUBJECTS_7_CD = ['sn', 'pc', 'maths'];
    const SUBJECTS_7_LM = ['ar', 'fr', 'ph'];
    const SUBJECTS_7_LO = ['ar', 'dm', 'pi'];

    public function load(ObjectManager $manager)
    {
        foreach ($this->getClassDatas() as [$classCode, $subjectCodes]) {
            $class = new Classe();
            $class->setName($classCode);
            $class->setCode('class.' . $classCode);

            foreach ($subjectCodes as $code) {
                $subject = $manager->getRepository(Subject::class)->findOneBy(['code' => "subject.$code"]);

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
            ['terminaleC',  self::SUBJECTS_7_CD],
            ['terminaleD',  self::SUBJECTS_7_CD],
            ['terminaleLM', self::SUBJECTS_7_LM],
            ['terminaleLO', self::SUBJECTS_7_LO],
        ];
    }

    public function getDependencies()
    {
        return [
            SubjectFixtures::class,
        ];
    }
}
