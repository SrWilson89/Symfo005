<?php

namespace App\Controller;

use App\Entity\Tarea;
use App\Form\TareaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tareas')]
class TareasController extends AbstractController
{
    #[Route('/new', name: 'app_tareas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarea = new Tarea();
        $form = $this->createForm(TareaType::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarea);
            $entityManager->flush();

            return $this->redirectToRoute('app_list', ['entity' => 'tareas'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tareas/new.html.twig', [
            'tarea' => $tarea,
            'form' => $form,
        ]);
    }
}