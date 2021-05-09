<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Resource;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resource")
 */
class ResourceController extends AbstractController
{
    /**
     * @Route("/", name="resource_index", methods={"GET"})
     */
    public function index(ResourceRepository $resourceRepository): Response
    {
        return $this->render('admin/resource/index.html.twig', [
            'resources' => $resourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="resource_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resource);
            $entityManager->flush();

            return $this->redirectToRoute('resource_index');
        }

        return $this->render('admin/resource/new.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resource_show", methods={"GET"})
     */
    public function show(Resource $resource): Response
    {
        return $this->render('admin/resource/show.html.twig', [
            'resource' => $resource,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resource_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resource $resource): Response
    {
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resource_index');
        }

        return $this->render('admin/resource/edit.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resource_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resource $resource): Response
    {
        if ($this->isCsrfTokenValid('delete' . $resource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resource_index');
    }
}
