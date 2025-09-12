<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;

class ListController extends AbstractController
{
    #[Route('/list/{entity}', name: 'app_list')]
    public function list(string $entity, EntityManagerInterface $entityManager): Response
    {
        $entityClass = 'App\\Entity\\' . ucfirst($entity);

        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException('Entity not found.');
        }

        $repository = $entityManager->getRepository($entityClass);
        $entities = $repository->findAll();

        $className = (new ReflectionClass($entityClass))->getShortName();

        $templatePath = strtolower($className) . '/index.html.twig';

        return $this->render($templatePath, [
            'entities' => $entities,
        ]);
    }
}