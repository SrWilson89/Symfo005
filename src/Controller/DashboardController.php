<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CustomerRepository $customerRepository, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            $customerCount = $customerRepository->count([]);
            $userCount = $userRepository->count([]);
            $monthlyCustomerData = $customerRepository->getMonthlyCustomerCount();

            return $this->render('dashboard/index.html.twig', [
                'customerCount' => $customerCount,
                'userCount' => $userCount,
                'monthlyCustomerData' => json_encode($monthlyCustomerData),
            ]);
        }
        
        return $this->render('security/login.html.twig', [
            'last_username' => '',
            'error' => null,
        ]);
    }
}