<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'level' => 'all'
        ]);
    }

    /**
     * @Route("/{level}", name="section")
     */
    public function section($level): Response
    {
        return $this->render('default/index.html.twig', [
            'level' => $level
        ]);
    }
}
