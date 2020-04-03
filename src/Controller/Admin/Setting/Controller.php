<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin\Setting;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/settings")
 */
class Controller extends AbstractController
{
    /**
     * @Route("/", name="admin_settings")
     */
    public function settings(): Response
    {
        return $this->render('admin/settings/index.html.twig', [
            'active' => null,
        ]);
    }

    /**
     * @Route("/users", name="admin_users_setting")
     */
    public function users(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/settings/user/index.html.twig', [
            'active' => 'setting-users',
            'users' => $users,
        ]);
    }
}
