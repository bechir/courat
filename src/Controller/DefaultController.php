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

use App\Repository\ClassRepository;
use App\Repository\DayRepository;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(PlanningRepository $planningRepository, ClassRepository $classRepository, DayRepository $dayRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'PlanningController',
            'classes' => $classRepository->findAll(),
            'plannings' => $planningRepository->findAll(),
            'days' => $dayRepository->findAll(),
        ]);
    }
}
