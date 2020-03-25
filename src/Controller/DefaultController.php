<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\ClassLevel;
use App\Repository\ClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager): Response
    {
        $classes = $entityManager->getRepository(Classe::class)->findAll();
        
        $filter = function($name) use($classes) {
            return array_filter($classes, fn($class) => $class->getLevel() == $name);
        };

        $filtered['primaire'] = $filter('primaire');
        $filtered['college'] = $filter('college');
        $filtered['lycee'] = $filter('lycee');
        $filtered['terminale'] = $filter('terminale');

        return $this->render('default/index.html.twig', [
            'level' => 'all',
            'classes' => $filtered
        ]);
    }

    public function sectionLevel(ClassLevel $level, ClassRepository $courseClassRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'level' => $level,
            'classes' => [$level->getName() => $courseClassRepository->findBy(['level' => $level])]
        ]);
    }
}
