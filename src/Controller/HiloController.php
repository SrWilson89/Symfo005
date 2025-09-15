<?php

namespace App\Controller;

use App\Entity\Hilo;
use App\Form\HiloType;
use App\Repository\HiloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hilo')]
final class HiloController extends AbstractController
{
    #[Route(name: 'app_hilo_index', methods: ['GET'])]
    public function index(HiloRepository $hiloRepository): Response
    {
        return $this->render('hilo/index.html.twig', [
            'hilos' => $hiloRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hilo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hilo = new Hilo();
        $form = $this->createForm(HiloType::class, $hilo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hilo);
            $entityManager->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'hilo'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hilo/new.html.twig', [
            'hilo' => $hilo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hilo_show', methods: ['GET'])]
    public function show(Hilo $hilo): Response
    {
        return $this->render('hilo/show.html.twig', [
            'hilo' => $hilo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hilo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hilo $hilo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HiloType::class, $hilo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'hilo'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hilo/edit.html.twig', [
            'hilo' => $hilo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hilo_delete', methods: ['POST'])]
    public function delete(Request $request, Hilo $hilo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hilo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hilo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_list', ['entity' => 'hilo'], Response::HTTP_SEE_OTHER);
    }
}