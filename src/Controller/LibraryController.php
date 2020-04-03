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

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController
{
    public function index(ArticleRepository $articleRepository)
    {
        return $this->render('library/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
}
