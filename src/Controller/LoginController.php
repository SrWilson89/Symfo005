<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(EntityManagerInterface $em): Response
    {
        return $this->render('login.html.twig', []);
    }

    #[Route('/recovery', name: 'app_recovery')]
    public function recovery(EntityManagerInterface $em): Response
    {
        return $this->render('recover-password.html.twig', []);
    }
}