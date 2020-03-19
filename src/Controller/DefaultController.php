<?php

namespace App\Controller;

use App\Entity\ClassLevel;
use App\Entity\CourseClass;
use App\Repository\CourseClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager): Response
    {
        $classes = $entityManager->getRepository(CourseClass::class)->findAll();
        $filtered['primaire'] = array_filter($classes, fn($class) => $class->getLevel() == 'primaire');
        $filtered['college'] = array_filter($classes, fn($class) => $class->getLevel() == 'college');
        $filtered['lycee'] = array_filter($classes, fn($class) => $class->getLevel() == 'lycee');
        $filtered['terminale'] = array_filter($classes, fn($class) => $class->getLevel() == 'terminale');

        return $this->render('default/index.html.twig', [
            'level' => 'all',
            'classes' => $filtered
        ]);
    }

    public function sectionLevel(ClassLevel $level, CourseClassRepository $courseClassRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'level' => $level,
            'classes' => [$level->getName() => $courseClassRepository->findBy(['level' => $level])]
        ]);
    }
}
