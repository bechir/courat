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

use App\Entity\DocumentCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DocumentCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getNames() as $name) {
            $type = new DocumentCategory();
            $type->setName('document.category.' . $name);

            $manager->persist($type);
        }

        $manager->flush();
    }

    public function getNames(): array
    {
        return [
            'cours',
            'exo',
            'epreuve_bac',
            'autre',
        ];
    }
}
