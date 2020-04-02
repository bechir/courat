<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/resource")
 */
class ResourceController extends AbstractController
{
    const BLOCK_PREFIX = 'resource';
    const BASE_ROUTE = 'admin_' . self::BLOCK_PREFIX;
    const BASE_PATH = 'admin/';

    /**
     * @Route("/", name="admin_resource", methods={"GET"})
     */
    public function index(ResourceRepository $resourceRepository): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/index.html.twig', [
            'resources' => $resourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_resource_new", methods={"GET","POST"})
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

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/new.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_resource_show", methods={"GET"})
     */
    public function show(Resource $resource): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/show.html.twig', [
            'resource' => $resource,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_resource_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resource $resource): Response
    {
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/edit.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_resource_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resource $resource): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resource);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::BASE_ROUTE);
    }
}
