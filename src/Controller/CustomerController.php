<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customer')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'app_customer_index', methods: ['GET'])]
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('customer/index.html.twig', [
            'entities' => $customerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_customer_new', methods: ['GET', 'POST'])]
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

    #[Route('/{id}/edit', name: 'app_customer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Customer $customer, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_list', ['entity' => 'customer']);
        }

        return $this->render('customer/edit.html.twig', [
            'name' => 'Editar Cliente',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_customer_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Customer $customer, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('app_list', ['entity' => 'customer']);
    }
}