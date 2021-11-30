<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{

    private $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Book::class);
        $this->security = $security;
    }

    public function searchFieldByName(string $name)
    {
        return $this->createQueryBuilder('b')
            ->where('b.name LIKE :buff')
            ->setParameter('buff','%'.$name.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function searchFieldByAuthor(string $author)
    {
        return $this->createQueryBuilder('b')
            ->where('b.author LIKE :buff')
            ->setParameter('buff','%'.$author.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getBooksByUserPaginator()
    {
        return $this->createQueryBuilder('e')
            ->join('e.libraries','l','l.book = e.id')
            ->where('l.user = :user')
            ->setParameter('user',$this->security->getUser())
            ->getQuery()
            ->getResult()
            ;

    }

    public function getBooksNotAddingToLibraryByUserPagination()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin("b.libraries", 'l',"WITH","l.user =:user") // Klauzula WITH dla dodania dodatkowej relaci w join
            ->setParameter('user',$this->security->getUser())                                   // WITH = AND W MYSQL
            ->where('l.book IS NULL')                                                   // select * from book b left join library l on b.id = l.book_id and l.user_id = 3 where l.book_id is null
            ->getQuery()
            ->getResult()
            ;
    }

    public function getAlreadyReadBooksByUserPaginator()
    {
        return $this->createQueryBuilder('e')
            ->join('e.libraries','l','l.book = e.id')
            ->where('l.user = :user')
            ->andWhere('l.page = e.page')
            ->setParameter('user',$this->security->getUser())
            ->getQuery()
            ->getResult()
        ;
    }

    public function getNotReadBooksByUserPaginator()
    {
        return $this->createQueryBuilder('e')
            ->join('e.libraries','l','l.book = e.id')
            ->where('l.user = :user')
            ->andWhere('l.page = 0')
            ->setParameter('user',$this->security->getUser())
            ->getQuery()
            ->getResult()
        ;
    }

    public function getWhileReadingBooksByUserPaginator()
    {
        return $this->createQueryBuilder('e')
            ->join('e.libraries','l','l.book = e.id')
            ->where('l.user = :user')
            ->andWhere('l.page != 0')
            ->andWhere('l.page != e.page')
            ->setParameter('user',$this->security->getUser())
            ->getQuery()
            ->getResult()
        ;
    }
}
