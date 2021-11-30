<?php

namespace App\Repository;

use App\Entity\OfferBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferBook[]    findAll()
 * @method OfferBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferBook::class);
    }

    // /**
    //  * @return OfferBook[] Returns an array of OfferBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfferBook
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
