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

use App\Entity\Info;
use App\Repository\InfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NewsController extends AbstractController
{
    public function index(InfoRepository $infoRepository)
    {
        return $this->render('news/index.html.twig', [
            'articles' => $infoRepository->findAll(),
        ]);
    }

    public function show(Info $info)
    {
        return new RedirectResponse($info->getLink());
    }
}
