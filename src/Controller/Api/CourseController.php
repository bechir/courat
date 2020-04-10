<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that manage the courses in the API.
 *
 * @Route("/course")
 */
class CourseController extends AbstractController
{
    /**
     * Retrieve a list of the most recent courses.
     *
     * @param Request $request: The HTTP Request
     *
     * @Route("s", name="api_courses_list")
     */
    public function paginateLatest(Request $request, CourseRepository $courseRepository): JsonResponse
    {
        $page = $request->query->getInt('page', 1);

        return $this->json($courseRepository->paginateLatest($page));
    }

    /**
     * Retrieve details of a course identified by it's ID.
     *
     * @param Course $course: The course object
     *
     * @Route("/{id}", name="api_course_details")
     */
    public function courseDetails(Course $course): JsonResponse
    {
        return $this->json($course);
    }
}
