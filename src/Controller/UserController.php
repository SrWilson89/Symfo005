<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    #[Route('/user/new', name: 'app_user_new')]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Se obtiene la contraseña del formulario (texto plano)
            $plainPassword = $form->get('password')->getData();

            // Se encripta la contraseña
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainPassword
            );
            $user->setPassword($hashedPassword);

            // Se asigna el rol por defecto
            $user->setRoles(['ROLE_USER']);

            $user->setDateAdd(new \DateTime());

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'user']);
        }

        return $this->render('user/new.html.twig', [
            'name' => 'Nuevo Usuario',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit')]
    public function edit(Request $request, User $user, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'password_required' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                );
                $user->setPassword($hashedPassword);
            }
            $user->setDateEdit(new \DateTime());
            $em->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'user']);
        }

        return $this->render('user/edit.html.twig', [
            'name' => 'Editar Usuario',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/{id}/delete', name: 'app_user_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('app_list', ['entity' => 'user']);
    }

    #[Route('/user/profile', name: 'app_user_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige al login si no hay usuario
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}