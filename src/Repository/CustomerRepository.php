<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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

    public function getMonthlyCustomerCount(): array
    {
        $qb = $this->createQueryBuilder('c');
        $result = $qb->select('SUBSTRING(c.dateAdd, 6, 2) AS month', 'COUNT(c.id) AS total')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->getQuery()
            ->getArrayResult();

        $data = [];
        $monthNames = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
        ];

        foreach ($result as $row) {
            $data[] = [$monthNames[$row['month']], (int) $row['total']];
        }

        return $data;
    }
}