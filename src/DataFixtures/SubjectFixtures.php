<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getSubjectCodes() as $code) {
            $subject = new Subject();
            $subject->setCode($code);

            $manager->persist($subject);
        }

        $manager->flush();
    }

    public function getSubjectCodes(): array
    {
        return [
            'ar',
            'eng',
            'maths',
            'pc',
            'hg',
            'sn',
            'ic',
            'ir',
        ];
    }
}
