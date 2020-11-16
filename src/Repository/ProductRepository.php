<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findSomeProducts($field, $value,$n)
    {
        return $this->createQueryBuilder('p')
            ->join('p.' . $field, 'c')
            ->where('c.name = :value')
            ->groupBy('c')
            ->setParameter('value', $value)
            ->setMaxResults($n)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findSomeProducts($field, $value,$n)
    {
        $offset = max(0, rand(0, 7 - $n - 1));
        return $this->createQueryBuilder('p')
            ->join('p.' . $field, 'c')
            ->where('c.name = :value')
            ->groupBy('c')
            ->setParameter('value', $value)
            ->setMaxResults($n)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
