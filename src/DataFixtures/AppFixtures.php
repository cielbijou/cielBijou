<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Commentaire;
use App\Entity\LigneCommande;
use App\Entity\Produit;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
   
    public function load(ObjectManager $manager): void
    {
    

        // Créer des catégories de bijoux
        $categorie1 = new Categorie();
        $categorie1->setLibelleCat('Bagues');
        $manager->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2->setLibelleCat('Colliers');
        $manager->persist($categorie2);

        $categorie3 = new Categorie();
        $categorie3->setLibelleCat('Bracelets');
        $manager->persist($categorie3);

        // Créer des produits
        $produit1 = new Produit();
        $produit1->setNomProd('BagueEnOr');
        $produit1->setDescription('Une magnifique bague en or 18 carats.');
        $produit1->setImageProd('B02.jpg');
        $produit1->setStockProd(30);
        $produit1->setPrixProd(49.99);
        $produit1->setUneCategorie($categorie1);
        $manager->persist($produit1);

        $produit2 = new Produit();
        $produit2->setNomProd('CollierEnOr');
        $produit2->setDescription('Collier délicat en or.');
        $produit2->setImageProd('C02.jpg');
        $produit2->setStockProd(20);
        $produit2->setPrixProd(29.99);
        $produit2->setUneCategorie($categorie2);
        $manager->persist($produit2);

        $produit3 = new Produit();
        $produit3->setNomProd('BoucleOreillePlume');
        $produit3->setDescription('Boucle d\'oreille élégante en or en forme de plume.');
        $produit3->setImageProd('O01.jpg');
        $produit3->setStockProd(15);
        $produit3->setPrixProd(19.99);
        $produit3->setUneCategorie($categorie3);
        $manager->persist($produit3);

        $produit4 = new Produit();
        $produit4->setNomProd('BagueEnArgent');
        $produit4->setDescription('Bague en argent accompagnée de son diamant.');
        $produit4->setImageProd('B01.jpg');
        $produit4->setStockProd(10);
        $produit4->setPrixProd(35.99);
        $produit4->setUneCategorie($categorie1);
        $manager->persist($produit4);

        $produit5 = new Produit();
        $produit5->setNomProd('BaguePerleNature');
        $produit5->setDescription('Bague en argent portant une véritable perle.');
        $produit5->setImageProd('B03.jpg');
        $produit5->setStockProd(25);
        $produit5->setPrixProd(19.99);
        $produit5->setUneCategorie($categorie1);
        $manager->persist($produit5);

        $produit6 = new Produit();
        $produit6->setNomProd('BagueEmeraude');
        $produit6->setDescription('Bague originale de la première collection ciel bijou.');
        $produit6->setImageProd('C1cb1.jpg');
        $produit6->setStockProd(35);
        $produit6->setPrixProd(45.99);
        $produit6->setUneCategorie($categorie1);
        $manager->persist($produit6);

        $produit7 = new Produit();
        $produit7->setNomProd('BagueCielBijou');
        $produit7->setDescription('Bague originale de la seconde collection Ciel Bijou.');
        $produit7->setImageProd('B2cb2.jpg');
        $produit7->setStockProd(40);
        $produit7->setPrixProd(45.99);
        $produit7->setUneCategorie($categorie1);
        $manager->persist($produit7);

        $produit8 = new Produit();
        $produit8->setNomProd('CollierChaineOr');
        $produit8->setDescription('Collier chainé en or.');
        $produit8->setImageProd('C01.jpg');
        $produit8->setStockProd(20);
        $produit8->setPrixProd(29.99);
        $produit8->setUneCategorie($categorie2);
        $manager->persist($produit8);

        $produit9 = new Produit();
        $produit9->setNomProd('CollierPorteBonheur');
        $produit9->setDescription('Collier en or avec son motif porte bonheur.');
        $produit9->setImageProd('C03.jpg');
        $produit9->setStockProd(10);
        $produit9->setPrixProd(35.99);
        $produit9->setUneCategorie($categorie2);
        $manager->persist($produit9);

        $produit10 = new Produit();
        $produit10->setNomProd('CollierGoutteDiamant');
        $produit10->setDescription('Collier original de la première collection Ciel Bijou.');
        $produit10->setImageProd('C1cb1.jpg');
        $produit10->setStockProd(35);
        $produit10->setPrixProd(69.99);
        $produit10->setUneCategorie($categorie2);
        $manager->persist($produit10);

        $produit11 = new Produit();
        $produit11->setNomProd('CollierCaraibe');
        $produit11->setDescription('Collier original de la seconde collection Ciel Bijou.');
        $produit11->setImageProd('C2cb2.jpg');
        $produit11->setStockProd(20);
        $produit11->setPrixProd(65.99);
        $produit11->setUneCategorie($categorie2);
        $manager->persist($produit11);

        $produit12 = new Produit();
        $produit12->setNomProd('BoucleOreilleLune');
        $produit12->setDescription('Boucle d\'oreille originale avec son motif de lune.');
        $produit12->setImageProd('O02.jpg');
        $produit12->setStockProd(25);
        $produit12->setPrixProd(35.99);
        $produit12->setUneCategorie($categorie3);
        $manager->persist($produit12);

        $produit13 = new Produit();
        $produit13->setNomProd('BoucleOreilleNoeud');
        $produit13->setDescription('Boucle d\'oreille en or avec un motif de noeud.');
        $produit13->setImageProd('O03.jpg');
        $produit13->setStockProd(10);
        $produit13->setPrixProd(39.99);
        $produit13->setUneCategorie($categorie3);
        $manager->persist($produit13);

        $produit14 = new Produit();
        $produit14->setNomProd('BoucleOreilleCoeur');
        $produit14->setDescription('Boucle d\'oreille originale de la première collection Ciel Bijou.');
        $produit14->setImageProd('O1cb1.jpg');
        $produit14->setStockProd(35);
        $produit14->setPrixProd(39.99);
        $produit14->setUneCategorie($categorie3);
        $manager->persist($produit14);

        $produit15 = new Produit();
        $produit15->setNomProd('BoucleOreilleElegante');
        $produit15->setDescription('Boucle d\'oreille originale de la seconde collection Ciel Bijou.');
        $produit15->setImageProd('O2cb2.jpg');
        $produit15->setStockProd(45);
        $produit15->setPrixProd(49.99);
        $produit15->setUneCategorie($categorie3);
        $manager->persist($produit15);

        // Créer des clients
        $client1 = new Client();
        $client1->setEmail('client1@example.com');
        $client1->setNom('Durand');
        $client1->setPrenom('Marie');
        $client1->setRoles(["ROLE_USER"]);
        $client1->setPassword('password');
        $manager->persist($client1);

        // Créer des commandes
        $commande1 = new Commande();
        $commande1->setDateCommande(new \DateTime('2010-04-01'));
        $commande1->setUnClient($client1);
        $manager->persist($commande1);

        // Créer des lignes de commande
        $ligneCommande1 = new LigneCommande();
        $ligneCommande1->setQuantite(1);
        $ligneCommande1->setUnProduit($produit1);
        $ligneCommande1->setUneCommande($commande1);
        $manager->persist($ligneCommande1);

        $ligneCommande2 = new LigneCommande();
        $ligneCommande2->setQuantite(2);
        $ligneCommande2->setUnProduit($produit2);
        $ligneCommande2->setUneCommande($commande1);
        $manager->persist($ligneCommande2);

        // Créer des commentaires
        $commentaire1 = new Commentaire();
        $commentaire1->setDateCommentaire(new \DateTime('2010-04-01'));
        $commentaire1->setContenuCommentaire('Bague magnifique, je l\'adore !');
        $commentaire1->setNoteCommentaire(5);
        $commentaire1->setUnProduit($produit1);
        $commentaire1->setUnClient($client1);
        $manager->persist($commentaire1);

        // Créer des promotions
        $promotion1 = new Promotion();
        $promotion1->setDateDebutPromo(new \DateTime('2010-04-01'));
        $promotion1->setDateFinPromo(new \DateTime('2010-04-01'));
        $promotion1->setRemisePromo(15.22);
        $promotion1->setUneCategorie($categorie2);
        $manager->persist($promotion1);

        // Enregistrer tous les objets dans la base de données
        $manager->flush();
    }
}
