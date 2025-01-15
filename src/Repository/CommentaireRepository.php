<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    //    /**
    //     * @return Commentaire[] Returns an array of Commentaire objects
    //     */
       public function findNote(): array
       {
           return $this->createQueryBuilder('c')
               ->select('c.noteCommentaire')
               ->orderBy('c.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
       }

    public function findCommentaireProduitById($id)
        {
            return $this->createQueryBuilder('c')
                ->innerJoin('c.unClient', 'client')
                ->where('c.unProduit = :val')  
                ->setParameter('val', $id)
                ->orderBy('c.dateCommentaire', 'DESC')
                ->setMaxResults(20)
                ->getQuery()
                ->getResult();
        }

    public function findCommentaireProduit(){
        $com = $this->createQueryBuilder('c')
        ->select(
            'c.id AS idCom',        
            'p.id AS idProduit',    
            'cl.id AS idClient',    
            'c.dateCommentaire', 
            'c.contenuCommentaire', 
            'c.noteCommentaire', 
            'cl.nom', 
            'cl.prenom'
        )
        ->innerJoin('c.unClient', 'cl')
        ->innerJoin('c.unProduit', 'p')
        ->orderBy('c.dateCommentaire', 'DESC')
        ->getQuery();
    
        return $com->getResult();
    }
    
        
        



    //    public function findOneBySomeField($value): ?Commentaire
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
