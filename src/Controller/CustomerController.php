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

    #[Route('/customer/{id}/edit', name: 'app_customer_edit')]
    public function edit(Request $request, Customer $customer, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer->setDateEdit(new \DateTime());
            $em->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'customer']);
        }

        return $this->render('customer/edit.html.twig', [
            'name' => 'Editar Cliente',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/{id}/delete', name: 'app_customer_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Customer $customer, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('app_list', ['entity' => 'customer']);
    }

    public function findBySearchTerm(string $term, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);

        if (!empty($term)) {
            $qb->andWhere('c.name LIKE :term OR c.cif LIKE :term')
                ->setParameter('term', '%' . $term . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function countBySearchTerm(string $term): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)');

        if (!empty($term)) {
            $qb->andWhere('c.name LIKE :term OR c.cif LIKE :term')
                ->setParameter('term', '%' . $term . '%');
        }

        return $qb->getQuery()->getSingleScalarResult();
    }

}