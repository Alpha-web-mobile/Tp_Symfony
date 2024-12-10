<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('b')
           ->andWhere('b.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('b.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneBySomeField($value): ?Book
   {
       return $this->createQueryBuilder('b')
           ->andWhere('b.exampleField = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
   
   /** * Recherche des livres par titre ou par auteur. 
   * * @param string $searchTerm * @return Book[] 
   */ public function findByTitleOrAuthor(string $searchTerm): array {
   return $this->createQueryBuilder('b') 
   ->leftJoin('b.author', 'a') 
   ->where('b.title LIKE :searchTerm')
   ->orWhere('a.firstName LIKE :searchTerm')
   ->orWhere('a.lastName LIKE :searchTerm') 
   ->setParameter('searchTerm', '%' . $searchTerm . '%') 
   ->getQuery() ->getResult(); }
}
