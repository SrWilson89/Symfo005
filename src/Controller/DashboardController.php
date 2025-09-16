<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use App\Repository\TareasRepository;
use App\Repository\HiloRepository;
use App\Repository\EstadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        UserRepository $userRepository,
        CustomerRepository $customerRepository,
        TareasRepository $tareasRepository,
        HiloRepository $hiloRepository,
        EstadosRepository $estadosRepository
    ): Response {
        $totalUsers = $userRepository->count([]);
        $totalCustomers = $customerRepository->count([]);
        $totalTareas = $tareasRepository->count([]);
        $totalHilos = $hiloRepository->count([]);
        $totalEstados = $estadosRepository->count([]);

        return $this->render('dashboard/index.html.twig', [
            'totalUsers' => $totalUsers,
            'totalCustomers' => $totalCustomers,
            'totalTareas' => $totalTareas,
            'totalHilos' => $totalHilos,
            'totalEstados' => $totalEstados,
        ]);
    }
}