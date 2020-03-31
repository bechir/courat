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

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\ClassRepository;
use App\Repository\DayRepository;
use App\Repository\PlanningRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning")
 */
class PlanningController extends AbstractController
{
    
    public function planning(DayRepository $dayRepository, SubjectRepository $subjectRepository, ClassRepository $classRepository, PlanningRepository $planningRepository)
    {
        return $this->render('common/planning.html.twig', [
            'controller_name' => 'PlanningController',
            'days' => $dayRepository->findAll(),
            'classes' => $classRepository->findAll(),
            'plannings' => $planningRepository->findAll(),
            'subjects' => $subjectRepository->findAll(),
        ]);
    }

}
