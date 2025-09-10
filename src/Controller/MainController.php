<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use App\Entity\Juego;

use Doctrine\ORM\EntityManagerInterface;

//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Cookie;
//use Symfony\Component\Validator\Constraints\DateTime;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('index.html.twig', []);
    }
}
