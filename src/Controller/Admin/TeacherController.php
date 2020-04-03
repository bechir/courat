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
use App\Form\TeacherCourseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_TEACHER")
 * @Route("/admin/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/new-course", name="admin_teacher_new_course")
     */
    public function create(): Response
    {
        $course = new Course();
        $form = $this->createForm(TeacherCourseType::class, $course);

        return $this->render('admin/teacher/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
