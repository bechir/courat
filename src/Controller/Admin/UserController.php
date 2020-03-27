<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller that manage security part of the backend.
 *
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="admin_users")
     */
    public function index(): Response
    {
        return $this->render('admin/user/list.html.twig', [
          'users' => $this->getDoctrine()->getRepository(User::class)->findAll(),
        ]);
    }

    /**
     * @Route("/{user}", name="admin_user_show")
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
          'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="admin_user_create")
     */
    public function create(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);

            $em->flush();

            $this->addFlash('success', "L'utilisateur a été créé avec succès.");

            return $this->redirectToRoute('admin_user_show', [
                'user' => $user->getId(),
            ]);
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_user_delete", methods={"POST"})
     */
    public function deleteUser(User $user, EntityManagerInterface $em)
    {
        if (!$user) {
            $this->addFlash('danger', "L'utilisateur est introuvable.");
        } else {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', "L'utilisateur a été supprimé.");
        }

        return $this->redirectToRoute('admin_users');
    }
}
