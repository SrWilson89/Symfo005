<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Customer;

use Doctrine\ORM\EntityManagerInterface;

final class ListController extends AbstractController
{
    #[Route('/list/{entity}', name: 'app_list')]
    public function list(string $entity, EntityManagerInterface $em): Response
    {
        $name = "";
        $items = array();
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

        switch ($entity) {
            case 'customer':
                $items = $em->getRepository(Customer::class)->findAll();
                $name = "Listado Clientes";
                break;
            
            default:
                die("Error! No se localizó la entidad: ".$entity);
                break;
        }

        return $this->render('list.html.twig', [
            "items" => $this->convertObjectsToArrays($items),
            "fields" => $fields[$entity],
            "name" => $name
        ]);
    }

    private function convertObjectsToArrays($items) {
        $return = [];
        foreach ($items as $item) {
            $return[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'cif' => $item->getCif(),
                'address' => $item->getAddress(),
                'postal' => $item->getPostal(),
                'location' => $item->getLocation(),
                'country' => $item->getCountry(),
                'notes' => $item->getNotes(),
                'date_add' => $item->getDateAdd() ? $item->getDateAdd()->format('Y-m-d H:i:s') : null,
                'date_edit' => $item->getDateEdit() ? $item->getDateEdit()->format('Y-m-d H:i:s') : null,
            ];
        }
        
        return $return;
    }
}