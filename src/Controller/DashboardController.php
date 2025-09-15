<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(UserRepository $userRepository, CustomerRepository $customerRepository): Response
    {
        $totalUsers = $userRepository->count([]);
        $totalCustomers = $customerRepository->count([]);

        return $this->render('dashboard/index.html.twig', [
            'totalUsers' => $totalUsers,
            'totalCustomers' => $totalCustomers,
        ]);
    }
}