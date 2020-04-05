<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
        $documents = $em->createQueryBuilder()->select('count(d.id)')->from('App:Document', 'd')
            ->getQuery()->getSingleScalarResult();

        $resources = $em->createQueryBuilder()->select('count(r.id)')->from('App:Resource', 'r')
            ->getQuery()->getSingleScalarResult();

        $users = $em->createQueryBuilder()->select('count(u.id)')->from('App:User', 'u')
            ->getQuery()->getSingleScalarResult();

        $teachers = $em->createQueryBuilder('u')->select('count(u.id)')
            ->from('App:User', 'u')
            ->where('u.roles like :role')
            ->setParameter('role', '%TEACHER%')
            ->getQuery()->getSingleScalarResult();

        $courses = $em->createQueryBuilder('c')->select('count(c.id)')
            ->from('App:Course', 'c')
            ->getQuery()->getSingleScalarResult();

        return [
            'users' => $users,
            'courses' => $courses,
            'resources' => $resources,
            'documents' => $documents,
            'teachers' => $teachers,
        ];
    }
}
