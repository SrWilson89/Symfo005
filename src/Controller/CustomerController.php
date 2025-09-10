<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Customer;

use Doctrine\ORM\EntityManagerInterface;

final class CustomerController extends AbstractController
{
    #[Route('/load', name: 'app_dummy')]
    public function load(EntityManagerInterface $em): Response
    {
        for ($i = 0; $i < 10000; $i++) {
            $item = new Customer();
            $item->setName("Cliente ".$i);
            $item->setCif("00000000A");
            $item->setAddress("Dirección Clinte ".$i);
            $item->setPostal("00000");
            $item->setLocation("Localidad ".$i);
            $item->setCountry("ESPAÑA");
            $item->setNotes("Nota del Cliente ".$i);
            $em->persist($item);
        }
        $em->flush();

        die("Cargado");
    }
}