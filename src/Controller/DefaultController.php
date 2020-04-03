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
use App\Entity\Day;
use App\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    public function planning(): Response
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('common/planning.html.twig', [
            'plannings' => $em->getRepository(Planning::class)->findAll(),
            'classes' => $em->getRepository(Classe::class)->findAll(),
            'days' => $em->getRepository(Day::class)->findAll(),
        ]);
    }

    public function contributors(): Response
    {
        return $this->render('default/contributor.html.twig');
    }

    public function library(): Response
    {
        return $this->render('library/index.html.twig');
    }
}
