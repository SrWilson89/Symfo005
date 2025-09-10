<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListController extends AbstractController
{
    #[Route('/list/{entity}', name: 'app_list')]
    public function list(string $entity, EntityManagerInterface $em, Request $request): Response
    {
        $name = "";
        $fields["customer"][] = "id";
        $fields["customer"][] = "name";
        $fields["customer"][] = "cif";
        $fields["customer"][] = "address";
        $fields["customer"][] = "postal";
        $fields["customer"][] = "location";
        $fields["customer"][] = "country";
        $fields["customer"][] = "notes";
        $fields["customer"][] = "date_add";
        $fields["customer"][] = "date_edit";
    
        $searchTerm = $request->query->get('q');
        $page = $request->query->getInt('page', 1);
        $limit = 25;
    
        switch ($entity) {
            case 'customer':
                $paginator = $em->getRepository(Customer::class)->paginateBySearchTerm($searchTerm, $page, $limit);
                $name = "Listado Clientes";
                break;
            
            default:
                die("Error! No se localizó la entidad: ".$entity);
                break;
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