<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
        $list = $courseRepository->paginate($class, $request->query->get('page', 1))->getItems();
        $courses = [];
        $subjects = $class->getSubjects();

        foreach ($subjects as $subject) {
            $courses[$subject->getCode()] = array_filter((array) $list, function (Course $course) use (&$subject) {
                return $course->getSubject()->getCode() === $subject->getCode();
            });
        }

        return $this->render('course/index.html.twig', [
            'class' => $class,
            'courses' => $courses,
        ]);
    }

    public function show(Course $course)
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
}
