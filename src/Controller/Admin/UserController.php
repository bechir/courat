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

use App\Entity\User;
use App\Form\Admin\UserType;
use App\Form\PasswordEditType;
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
     * Retrieve the lateste registrated users from the database.
     */
    public function latest(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->getLatest();

        return $this->render('admin/user/table.html.twig', [
            'users' => $users,
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

            $roles = [];

            foreach ($form->get('roles')->getData() as $role) {
                $roles[] = $role->getType();
            }

            $user->setRoles($roles);
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
     * @Route("/change-password", name="admin_user_password_edit")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le mot de passe a été changé.');

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/user/password-edit.html.twig', [
            'active' => 'editPassword',
            'form' => $form->createView(),
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
