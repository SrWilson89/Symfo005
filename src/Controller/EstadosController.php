<?php

namespace App\Controller;

use App\Entity\Estados;
use App\Form\EstadosType;
use App\Repository\EstadosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/estados')]
final class EstadosController extends AbstractController
{
    #[Route(name: 'app_estados_index', methods: ['GET'])]
    public function index(EstadosRepository $estadosRepository): Response
    {
        return $this->render('estados/index.html.twig', [
            'estados' => $estadosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estados_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estado = new Estados();
        $form = $this->createForm(EstadosType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estado);
            $entityManager->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'estados'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estados/new.html.twig', [
            'estado' => $estado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estados_show', methods: ['GET'])]
    public function show(Estados $estado): Response
    {
        return $this->render('estados/show.html.twig', [
            'estado' => $estado,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estados_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estados $estado, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstadosType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'estados'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estados/edit.html.twig', [
            'estado' => $estado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estados_delete', methods: ['POST'])]
    public function delete(Request $request, Estados $estado, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estado->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($estado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_list', ['entity' => 'estados'], Response::HTTP_SEE_OTHER);
    }
}