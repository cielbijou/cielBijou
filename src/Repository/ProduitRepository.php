<?php

namespace App\Repository;

use Exception;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    public function findByCategorie($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.uneCategorie = :val')
            ->setParameter('val', $value)
            ->orderBy('p.nomProd', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCielBijou(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.imageProd LIKE :val')
            ->setParameter('val', '%cb%')
            ->orderBy('p.nomProd', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCielBijouCollection1(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.imageProd LIKE :val')
            ->setParameter('val', '%1cb%')
            ->orderBy('p.nomProd', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByCielBijouCollection2(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.imageProd LIKE :val')
            ->setParameter('val', '%2cb%')
            ->orderBy('p.nomProd', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function setStock(int $id, int $qte): void
    {
        // Récupération de la connexion à la base de données via Doctrine DBAL
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE produit
                SET stock_prod = stock_prod - :qte
                WHERE id = :id;';

        try {
            // Préparation de la requête SQL
            $stmt = $conn->prepare($sql);
            // Exécution de la requête avec les paramètres
            $stmt->execute([
                'qte' => $qte,
                'id'  => $id
            ]);
        } catch (Exception $e) {
            // Gestion des erreurs, vous pouvez loguer l'erreur ou la relancer selon votre logique
            throw new \RuntimeException("Erreur lors de la mise à jour du stock: " . $e->getMessage());
        }
    }
    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
