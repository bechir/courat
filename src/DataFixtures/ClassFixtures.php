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
    const SUBJECTS_4_AS = ['hg', 'sn', 'ic', 'ir', 'fr'];
    const SUBJECTS_7_CD = ['sn', 'pc', 'maths'];
    const SUBJECTS_7_LM = ['ar', 'dm', 'pi'];
    const SUBJECTS_7_LO = ['ph', 'fr', 'ar'];

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
