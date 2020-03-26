<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends AbstractController
{
    public function index(Request $request, Classe $class, CourseRepository $courseRepository)
    {
        return $this->render('course/index.html.twig', [
            'class' => $class,
            'courses' => $courseRepository->paginate($class, $request->query->get('page', 1)),
        ]);
    }

    public function show(Course $course)
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
}
