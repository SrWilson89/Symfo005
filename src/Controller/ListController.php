<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ListController extends AbstractController
{
    #[Route('/list/{entity}', name: 'app_list')]
    public function list(string $entity, EntityManagerInterface $em, Request $request): Response
    {
        $name = "";
        $fields = [];
        $repository = null;

        $fields['customer'] = ["id", "name", "cif", "address", "postal", "location", "country", "notes", "date_add", "date_edit"];
        $fields['user'] = ["id", "email", "roles"];

        $searchTerm = $request->query->get('q');
        $page = $request->query->getInt('page', 1);
        $limit = 25;

        switch ($entity) {
            case 'customer':
                $repository = $em->getRepository(Customer::class);
                $paginator = $repository->paginateBySearchTerm($searchTerm, $page, $limit);
                $name = "Listado de Clientes";
                break;
            case 'user':
                $repository = $em->getRepository(User::class);
                // Si necesitas paginación para usuarios, debes crear un método paginateBySearchTerm en UserRepository.php
                // Por ahora, usamos findAll() y pasamos los datos manualmente.
                $items = $repository->findAll();
                $name = "Listado de Usuarios";
                return $this->render('list.html.twig', [
                    "items" => $items,
                    "fields" => $fields[$entity],
                    "name" => $name,
                    "totalPages" => 1, // Valor por defecto ya que no hay paginación implementada aún.
                    "page" => 1,
                    "limit" => count($items),
                    "totalItems" => count($items)
                ]);
            default:
                throw $this->createNotFoundException('Error! No se localizó la entidad: ' . $entity);
        }

        $totalPages = ceil(count($paginator) / $limit);

        return $this->render('list.html.twig', [
            "items" => $paginator,
            "fields" => $fields[$entity],
            "name" => $name,
            "totalPages" => $totalPages,
            "page" => $page,
            "limit" => $limit,
            "totalItems" => count($paginator)
        ]);
    }

}