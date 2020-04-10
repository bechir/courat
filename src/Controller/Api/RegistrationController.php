<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="api_registration", methods={"POST"})
     */
    public function index(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $jwtTokenManager,
        UserPasswordEncoderInterface $passwordEncoder)
    {
        $data = json_decode($request->getContent(), true);

        $user = (new User())
            ->setUsername($data['username'])
            ->setPassword($data['password']);

        $violations = $validator->validate($user);

        if ($violations->count() > 0) {
            $message = [];
            foreach ($violations as $v) {
                $message[] = $v->getMessage();
            }

            return $this->json(
                array_values(array_unique($message)),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $user->setPassword($passwordEncoder->encodePassword($user, $data['password']));
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json($jwtTokenManager->create($user));
    }
}
