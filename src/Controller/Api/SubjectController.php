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

use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that manage the subjects in the API.
 *
 * @Route("/subject")
 */
class SubjectController extends AbstractController
{
    /**
     * Retrieve the subjects list.
     *
     * @Route("/list", name="api_subjects_list")
     */
    public function list(SubjectRepository $subjectRepository): JsonResponse
    {
        return $this->json($subjectRepository->findAll());
    }
}
