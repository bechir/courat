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

use App\Repository\ArticleCategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\ClassRepository;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function index(
        ArticleRepository $articleRep,
        ArticleCategoryRepository $articleCategoryRep,
        SubjectRepository $subjectRepository,
        ClassRepository $classRepository)
    {
        return $this->render('library/index.html.twig', [
            'articles' => $articleRep->findAll(),
            'categories' => $articleCategoryRep->findAll(),
            'subjects' => $subjectRepository->findAll(),
            'classes' => $classRepository->findAll(),
        ]);
    }

    public function filter(Request $request, ArticleRepository $articleRepository): Response
    {
        sleep(1);
        $articles = $articleRepository->filter($request->query);

        return $this->render('library/_articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    public function upload(): Response
    {
        return $this->render('library/upload.html.twig');
    }
}
