<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @return Paginator Returns a Paginator object
     */
    public function paginateBySearchTerm(?string $term, int $page = 1, int $limit = 25): Paginator
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        if ($term) {
            $qb->andWhere($qb->expr()->like('c.name', ':term'))
               ->orWhere($qb->expr()->like('c.cif', ':term'))
               ->setParameter('term', '%'.$term.'%');
        }

        return new Paginator($qb);
    }
}