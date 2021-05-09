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

use App\Entity\Classe;
use App\Repository\ClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that manage the classes in the API.
 *
 * @Route("/class")
 */
class ClassController extends AbstractController
{
    /**
     * Retrieve a list of classes.
     *
     * @Route("/list", name="api_classes_list")
     */
    public function paginateLatest(ClassRepository $classRepository): JsonResponse
    {
        return $this->json($classRepository->findAll());
    }

    /**
     * Retrieve details of a class identified by it's ID.
     *
     * @param Course $class: The class object
     *
     * @Route("/{id}", name="api_class_details")
     */
    public function classDetails(Classe $class): JsonResponse
    {
        return $this->json($class->jsonSerializeDetails());
    }
}
