<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneCommande>
 */
class LigneCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommande::class);
    }

       public function findId($commandeId): array
       {
           return $this->createQueryBuilder('l')
               ->select('unProduitId')
               ->andWhere('l.uneCommandeId = :val')
               ->setParameter('val', $commandeId)
               ->orderBy('unProduitId', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       
       public function findProduitCommande($commande): array
       {
           return $this->createQueryBuilder('l') 
               ->where('l.uneCommande = :val') 
               ->setParameter('val', $commande)
               ->orderBy('l.uneCommande', 'ASC')
               ->getQuery()
               ->getResult();
       }
       
    //    public function findOneBySomeField($value): ?LigneCommande
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
