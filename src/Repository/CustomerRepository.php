<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findBySearchTerm(string $term, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);

        if (!empty($term)) {
            $qb->andWhere('c.nombre LIKE :term OR c.email LIKE :term')
                ->setParameter('term', '%' . $term . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function countBySearchTerm(string $term): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)');

        if (!empty($term)) {
            $qb->andWhere('c.nombre LIKE :term OR c.email LIKE :term')
                ->setParameter('term', '%' . $term . '%');
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}