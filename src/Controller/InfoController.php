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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InfoController extends AbstractController
{
    public function index()
    {
        return $this->render('info/index.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }
}
