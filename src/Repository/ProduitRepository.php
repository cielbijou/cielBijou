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

    public function findByPrix($ordre): array
    {
    // Vérifie si l'ordre est valide, sinon utilise 'ASC' par défaut
    $ordre = ($ordre === 'DESC') ? 'DESC' : 'ASC';

    return $this->createQueryBuilder('p')
        ->orderBy('p.prixProd', $ordre) // Utilise directement 'ASC' ou 'DESC' dans orderBy
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    public function findByCategorie($value, $ordre): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.uneCategorie = :val')
            ->OrderBy('p.prixProd', $ordre)
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findById($id): array {
        return $this->createQueryBuilder('p')
        ->select('p.id, p.nomProd, p.description, p.imageProd, p.prixProd')
        ->where('p.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }

    public function findPanier($id) : array {
        return $this->createQueryBuilder('p')
        ->select('p.id, p.nomProd, p.description, p.imageProd, p.prixProd, pr.remisePromo')
        ->innerJoin(
            'App\Entity\Categorie', // L'entité ou table pour la catégorie
            'c',                   // Alias
            'WITH',                // Clause personnalisée
            'p.uneCategorie = c.id' // Condition personnalisée de la jointure
        )
        ->innerJoin('App\Entity\Promotion','pr','WITH','p.uneCategorie = pr.uneCategorie')
        ->where('p.id = :id')
        ->setParameter('id', $id)
        ->orderBy('p.id', 'ASC')
        ->getQuery()
        ->getResult()
    ;
   }

    public function findByCielBijou($ordre): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.imageProd LIKE :val')
            ->OrderBy('p.prixProd', $ordre)
            ->setParameter('val', '%cb%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCielBijouCollection1($ordre): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.imageProd LIKE :val')
            ->OrderBy('p.prixProd', $ordre)
            ->setParameter('val', '%1cb%')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByCielBijouCollection2($ordre): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.imageProd LIKE :val')
            ->OrderBy('p.prixProd', $ordre)
            ->setParameter('val', '%2cb%')
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

    public function getPromotion($ordre){
        $qb = $this->createQueryBuilder('p')
        ->select('p.id, p.nomProd, p.description, p.imageProd, p.stockProd, p.prixProd, c.libelleCat, pr.remisePromo')
        ->innerJoin(
            'App\Entity\Categorie', // L'entité ou table pour la catégorie
            'c',                   // Alias
            'WITH',                // Clause personnalisée
            'p.uneCategorie = c.id' // Condition personnalisée de la jointure
        )
        ->innerJoin('App\Entity\Promotion','pr','WITH','p.uneCategorie = pr.uneCategorie')
        ->where('pr.dateDebutPromo < :now')
        ->andWhere('pr.dateFinPromo > :now')
        ->orderBy('c.libelleCat', 'ASC') 
        ->addOrderBy('p.prixProd', $ordre)
        ->setParameter('now', new \DateTime()) 
        ->getQuery();
    
        return $qb->getResult();

        }

}
