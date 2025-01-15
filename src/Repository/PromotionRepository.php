<?php

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Promotion>
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

       /**
        * @return Promotion[] Returns an array of Promotion objects
        */
       public function findPromo(): array
       {
            $currentDate = new \DateTime();

           return $this->createQueryBuilder('p')
                ->andWhere('p.dateDebutPromo <= :currentDate')
                ->andWhere('p.dateFinPromo >= :currentDate')
                ->setParameter('currentDate', $currentDate)
               ->orderBy('p.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       public function getCategoriePromo() : array {
            return $this->createQueryBuilder('p')
                ->orderBy('p.id', 'ASC')
                ->getQuery()
                ->getResult();
       }

    //    public function findOneBySomeField($value): ?Promotion
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
