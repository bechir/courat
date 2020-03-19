<?php

namespace App\Controller;

use App\Entity\CourseClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CourseController extends AbstractController
{
    public function index(CourseClass $courseClass)
    {
        return $this->render('course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }
}
