<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('index.html.twig', [
            'name' => 'Dashboard'
        ]);
    }
}