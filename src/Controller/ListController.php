<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    private const MAX_PER_PAGE = 10;

    #[Route('/list/{entity}', name: 'app_list')]
    public function list(string $entity, Request $request, CustomerRepository $customerRepository, UserRepository $userRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $searchTerm = $request->query->get('q', '');

        if ($entity === 'customer') {
            $items = $customerRepository->findBySearchTerm($searchTerm, $page, self::MAX_PER_PAGE);
            $totalItems = $customerRepository->countBySearchTerm($searchTerm);
            $fields = ['Id', 'Nombre', 'CIF', 'Dirección', 'Código Postal', 'Localidad', 'País', 'Notas', 'Fecha de alta', 'Fecha de edición'];
            $name = 'Listado de Clientes';
        } elseif ($entity === 'user') {
            $items = $userRepository->findBySearchTerm($searchTerm, $page, self::MAX_PER_PAGE);
            $totalItems = $userRepository->countBySearchTerm($searchTerm);
            $fields = ['Id', 'Email', 'Roles'];
            $name = 'Listado de Usuarios';
        } else {
            throw $this->createNotFoundException('Entity not found.');
        }

        $totalPages = ceil($totalItems / self::MAX_PER_PAGE);

        return $this->render('list.html.twig', [
            'items' => $items,
            'fields' => $fields,
            'name' => $name,
            'page' => $page,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }
}