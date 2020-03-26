<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/home/index.html.twig', [
        ]);
    }
}
