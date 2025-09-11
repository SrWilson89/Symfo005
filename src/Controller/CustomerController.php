<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    #[Route('/customer/new', name: 'app_customer_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer->setDateAdd(new \DateTime());
            
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'customer']);
        }

        return $this->render('customer/new.html.twig', [
            'name' => 'Nuevo Cliente',
            'form' => $form->createView(),
        ]);
    }
}