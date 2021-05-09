<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getSubjectCodes() as $code) {
            $subject = new Subject();
            $subject->setCode('subject.' . $code);

            $manager->persist($subject);
        }

        $manager->flush();
    }

    public function getSubjectCodes(): array
    {
        return [
            'ar',
            'maths',
            'pc',
            'sn',
            'ir',
            'fr',
            'dm',
            'pi',
            'ph',
        ];
    }
}
