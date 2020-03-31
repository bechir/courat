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

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\ClassRepository;
use App\Repository\DayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/", name="planning")
     */
    public function index(DayRepository $dayRepository, ClassRepository $classRepository)
    {
        return $this->render('admin/planning/index.html.twig', [
            'controller_name' => 'PlanningController',
            'days' => $dayRepository->findAll(),
            'classes' => $classRepository->findAll()
        ]);
    }

    /**
     * Create new planning.
     *
     * @param Request $request The Request
     *
     * @Route("/new", name="admin_planning_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $planning = new Planning;
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('planning');
        }

        return $this->render('admin/planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }
}
