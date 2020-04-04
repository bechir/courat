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
use App\Repository\ClassRepository;
use App\Repository\DayRepository;
use App\Repository\InfoRepository;
use App\Repository\PlanningRepository;
use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(InfoRepository $infoRepository, ResourceRepository $resourceRepository, PlanningRepository $planningRepository, ClassRepository $classRepository, DayRepository $dayRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name'   =>  'PlanningController',
            'classes'           =>  $classRepository->findAll(),
            'plannings'         =>  $planningRepository->findAll(),
            'days'              =>  $dayRepository->findAll(),
            'resources'         =>  $resourceRepository->findAll(),
            'infos'             =>  $infoRepository->findAll()
        ]);
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
}
