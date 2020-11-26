<?php

namespace App\Repository;

use App\Entity\Product;
use App\Model\SearchData;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findSomeProducts($field, $value, $n)
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

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findDiscountProduct()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.promo = 1')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findSearch(SearchData $search)
    {
        $query = $this->getSearchQuery($search)->getQuery();

        return $this->paginator->paginate($query, $search->page, 2);
    }

    /**
     * @return integer[] Returns an array of integer
     */
    public function findMinMax(SearchData $search)
    {
        $results = $this->getSearchQuery($search)
                 ->select('MIN(p.price) as min','MAX(p.price) as max')
                 ->getQuery()
                 ->getScalarResult();

        return [(int)$results[0]['min'],(int)$results[0]['max']];
    }

    public function getSearchQuery(SearchData $search) : QueryBuilder
    {
        $query = $this->createQueryBuilder('p')
            ->select('p', 'c')
            ->join('p.category', 'c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->min)) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $search->max);
        }

        if (!empty($search->promo)) {
            $query = $query
                ->andWhere('p.promo = 1');
        }

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        return $query;
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
