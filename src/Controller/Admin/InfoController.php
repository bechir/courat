<?php

namespace App\Controller\Admin;

use App\Entity\Info;
use App\Form\InfoType;
use App\Repository\InfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/info")
 */
class InfoController extends AbstractController
{
    const BLOCK_PREFIX = 'info';
    const BASE_ROUTE = 'admin_' . self::BLOCK_PREFIX;
    const BASE_PATH = 'admin/';

    /**
     * @Route("/", name="admin_info", methods={"GET"})
     */
    public function index(InfoRepository $infoRepository): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/index.html.twig', [
            'infos' => $infoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_info_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $info = new Info();
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($info);
            $entityManager->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/new.html.twig', [
            'info' => $info,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_info_show", methods={"GET"})
     */
    public function show(Info $info): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/show.html.twig', [
            'info' => $info,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Info $info): Response
    {
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/edit.html.twig', [
            'info' => $info,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_info_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Info $info): Response
    {
        if ($this->isCsrfTokenValid('delete'.$info->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($info);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::BASE_ROUTE);
    }
}
