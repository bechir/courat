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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    public function index()
    {
        return $this->render('news/index.html.twig', [
        ]);
    }

    public function show(Info $info)
    {
        return $this->render('news/show.html.twig', [
            'article' => $info,
        ]);
    }
}
