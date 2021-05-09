<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Entity\Planning;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that manage the plannings in the API.
 *
 * @Route("/planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/", name="api_planning")
     */
    public function index(PlanningRepository $planningRepository)
    {
        $plannings = $planningRepository->findAll();

        $result = [];

        foreach ($plannings as $planning) {
            $data = [];
            $data['class'] = $planning->getClasses()->get(0)->getName();

            foreach ($planning->getSubjects() as $subject) {
                $data['subjects'][] = $subject->getCode();
            }

            $result[$planning->getDay()->getName()] = $data;
        }

        return $this->json($result);
    }

    /**
     * Retrieve detail of a planning identified by it's ID.
     *
     * @param Planning $planning: The course object
     *
     * @Route("/{id}", name="api_planning_detail")
     */
    public function courseDetails(Planning $planning): JsonResponse
    {
        return $this->json($planning);
    }
}
