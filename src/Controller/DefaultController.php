<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'level' => 'all'
        ]);
    }

    public function section($level): Response
    {
        return $this->render('default/index.html.twig', [
            'level' => $level
        ]);
    }
}
