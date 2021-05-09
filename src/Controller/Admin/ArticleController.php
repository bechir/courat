<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
    const BLOCK_PREFIX = 'article';
    const BASE_ROUTE = 'admin_' . self::BLOCK_PREFIX;
    const BASE_PATH = 'admin/';

    /**
     * @Route("/", name="admin_article", methods={"GET"})
     */
    public function index(ArticleRepository $infoRepository): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/index.html.twig', [
            'articles' => $infoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::BASE_ROUTE);
    }
}
