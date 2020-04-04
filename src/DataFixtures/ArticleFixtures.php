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

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Classe;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $classes = $manager->getRepository(Classe::class)->findAll();
        $subjects = $manager->getRepository(Subject::class)->findAll();
        $categories = $manager->getRepository(ArticleCategory::class)->findAll();

        foreach ($this->getData() as [$title, $path]) {
            $article = (new Article())
                ->setTitle($title)
                ->setUrl($path)
                ->setCategory($categories[mt_rand(0, count($categories) - 1)])
                ->setClasse($classes[mt_rand(0, count($classes) - 1)])
                ->setSubject($subjects[mt_rand(0, count($subjects) - 1)]);

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getData(): array
    {
        $data = [];

        for ($i = 0; $i < 30; ++$i) {
            $data[] = ["Test de test $i", "a4cd34fab32$i.pdf"];
        }

        return $data;
    }

    public function getDependencies()
    {
        return [
            ClassFixtures::class,
            SubjectFixtures::class,
            ArticleCategoryFixtures::class,
        ];
    }
}
