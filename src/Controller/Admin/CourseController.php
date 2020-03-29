<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/course")
 */
class CourseController extends AbstractController
{
    /**
     * The courses listing page.
     *
     * @Route("/", name="admin_courses", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('admin/course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    /**
     * Retrieve the lateste course from the database.
     */
    public function latest(): Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->getLatest();

        return $this->render('admin/course/table.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * Create new course.
     *
     * @param Request $request The Request
     *
     * @Route("/new", name="admin_course_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('admin_courses');
        }

        return $this->render('admin/course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * The course details page.
     *
     * @param Course $course The course, identified by it's (feteched by doctrine)
     *
     * @Route("/{id}", name="admin_course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('admin/course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * Edit a course.
     *
     * @param Request $request The Request
     * @param Course  $course  The course to edit, identified by it's (feteched by doctrine)
     *
     * @Route("/{id}/edit", name="admin_course_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Course $course): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_courses');
        }

        return $this->render('admin/course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete a course from the database.
     *
     * @param Request $request The Request
     * @param Course  $course  The course to delete, identified by it's (feteched by doctrine)
     *
     * @Route("/{id}", name="admin_course_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Course $course): Response
    {
        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_courses');
    }
}
