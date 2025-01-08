<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

       /**
        * @return Categorie[] Returns an array of Categorie objects
        */
       public function findCategorie($cat): array
       {
           return $this->createQueryBuilder('c')
                ->select('c.libelleCat')
               ->andWhere('c.id = :val')
               ->setParameter('val', $cat)
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Categorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
