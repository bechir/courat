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
use App\Repository\PlanningRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManager;
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
    public function index(DayRepository $dayRepository, SubjectRepository $subjectRepository, ClassRepository $classRepository, PlanningRepository $planningRepository)
    {
        return $this->render('admin/planning/index.html.twig', [
            'controller_name' => 'PlanningController',
            'days' => $dayRepository->findAll(),
            'classes' => $classRepository->findAll(),
            'plannings' => $planningRepository->findAll(),
            'subjects' => $subjectRepository->findAll(),
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
        $planning = new Planning();
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

    /**
     * Undocumented function.
     *
     * @Route("/deleteAll", name="admin_planning_deleteAll", methods={"GET","POST"})
     */
    public function deleteAll(Request $request, EntityManager $entityManager): Response
    {
        // $planning = new Planning;
        // $form = $this->createForm(PlanningType::class, $planning);
        // $form->handleRequest($request);

        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeUpdate($platform->getTruncateTableSQL('planning', true));

        return $this->redirectToRoute('planning');
    }
}
