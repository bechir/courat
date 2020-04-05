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
use App\Entity\Document;
use App\Entity\DocumentCategory;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DocumentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $classes = $manager->getRepository(Classe::class)->findAll();
        $subjects = $manager->getRepository(Subject::class)->findAll();
        $categories = $manager->getRepository(DocumentCategory::class)->findAll();

        $findEntity = function ($type, $key) use ($classes, $subjects, $categories) {
            switch ($type) {
                case 'class':
                    foreach ($classes as $class) {
                        if ($class->getName() == $key) {
                            return $class;
                        }
                    }

                break;

                case 'subject':
                    foreach ($subjects as $subject) {
                        if ($subject->getCode() == "subject.$key") {
                            return $subject;
                        }
                    }

                break;

                case 'category':
                    foreach ($categories as $category) {
                        if ($category->getName() == "document.category.$key") {
                            return $category;
                        }
                    }

                break;

                default:
                    throw new \Exception("Invalid type $type");
            }
        };

        foreach ($this->getData() as [$title, $category, $path, $class, $subject]) {
            $document = (new Document())
                ->setTitle($title)
                ->setPath($path)
                ->setCategory($findEntity('category', $category))
                ->setClasse($findEntity('class', $class))
                ->setSubject($findEntity('subject', $subject))
                ->setEnabled(true);

            $manager->persist($document);
        }

        $manager->flush();
    }

    public function getData(): array
    {
        return [
            // Title                                          Category            Path              Classe        Subject
            // ['Annales du Baccalauréat National C & TMGM',   'annale',   'baccmaths.pdf',     'terminaleC',   'maths'],
            // ['الدالة اللوغاريتمية النبيرية',                             'annale',   '7LOcoursln.pdf',    'terminaleLO',  'maths'],
            // ['Session normal 2016',                         'annale',   'BacA2016sn.pdf',    'terminaleLM',  'maths'],
            // ['Session complémentaire 2016',                 'annale',   'BacC2016comp.pdf',  'terminaleC',   'maths'],
            // ['Session normal 2016',                         'annale',   'BacC2016sn.pdf',    'terminaleC',   'maths'],
            // ['Corrigé des sujets du Baccalauréat',          'annale',   'bacd.pdf',          'terminaleD',   'maths'],
            // ['Session Complémentaire 2015',                 'annale',   'BacD2015sc.pdf',    'terminaleC',   'maths'],
        ];
    }

    public function getDependencies()
    {
        return [
            ClassFixtures::class,
            SubjectFixtures::class,
            DocumentCategoryFixtures::class,
        ];
    }
}
