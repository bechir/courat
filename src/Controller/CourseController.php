<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Controller;

use App\Entity\Classe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CourseController extends AbstractController
{
    public function index(Classe $class)
    {
        return $this->render('course/index.html.twig', [
            'class' => $class,
        ]);
    }
}
