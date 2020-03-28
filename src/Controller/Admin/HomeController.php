<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(EntityManagerInterface $em)
    {
        return $this->render('admin/home/index.html.twig', [
            'data' => $this->getStats($em),
        ]);
    }

    public function getStats(EntityManagerInterface $em)
    {
        $qb = $em->createQueryBuilder();

        $users = $qb->select('count(u.id)')->from('App:User', 'u')
            ->getQuery()->getSingleScalarResult();

        $courses = $em->createQueryBuilder('c')->select('count(c.id)')
            ->from('App:Course', 'c')
            ->getQuery()->getSingleScalarResult();

        return [
            'users' => $users,
            'courses' => $courses,
        ];
    }
}
