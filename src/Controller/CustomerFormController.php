<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomerFormController extends AbstractController
{
    #[Route('/customer/new', name: 'app_customer_new')]
    #[Route('/customer/edit/{id}', name: 'app_customer_edit')]
    public function form(Request $request, EntityManagerInterface $em, Customer $customer = null): Response
    {
        if (!$customer) {
            $customer = new Customer();
        }

        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'customer']);
        }

        return $this->render('customer_form/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/delete/{id}', name: 'app_customer_delete')]
    public function delete(EntityManagerInterface $em, Customer $customer): Response
    {
        if (!$customer) {
            throw $this->createNotFoundException('Cliente no encontrado.');
        }

        $em->remove($customer);
        $em->flush();

        return $this->redirectToRoute('app_list', ['entity' => 'customer']);
    }
}