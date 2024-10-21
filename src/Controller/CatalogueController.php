<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{

    private $commentaireRepository;
    private $produitRepository;
    
    public function __construct(CommentaireRepository $commentaireRepository, ProduitRepository $produitRepository)
    {
        $this->commentaireRepository = $commentaireRepository;
        $this->produitRepository = $produitRepository;
    }
    
    function Notation() {
        $notes = $this->commentaireRepository->findAll();
        $produits = $this->produitRepository->findAll(); 
    
        $result = [];
    
        foreach ($produits as $produit) {
            $compteur = 0;
            $moyenne = 0;
    
            foreach ($notes as $note) {
                if ($note->getUnProduit()->getId() == $produit->getId()) {
                    $compteur++;
                    $moyenne += $note->getNoteCommentaire();
                }
            }
    
            if ($compteur > 1) {
                $moyenne /= $compteur; 
            } elseif ($compteur == 0) {
                $moyenne = 10; 
            } 
            $result[] = [
                'produitId' => $produit->getId(),
                'note' => $moyenne,
            ];
        }
    
        return $result;
    }
    
    #[Route('/catalogue', name: 'catalogue')]
    public function index(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou', name: 'catalogue_CielBijou')]
    public function indexCielBijou(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCielBijou(),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou/Collection1', name: 'catalogue_Collection1')]
    public function indexCollection1(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCielBijouCollection1(),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou/Collection2', name: 'catalogue_Collection2')]
    public function indexCollection2(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCielBijouCollection2(),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou/prixCroissant', name: 'catalogue_croissant')]
    public function indexCroissant(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findBy([], ['prixProd' => 'ASC']),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou/prixDecroissant', name: 'catalogue_decroissant')]
    public function indexDecroissant(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findBy([], ['prixProd' => 'DESC']),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/{id}', name: 'catalogue_cat')]
    public function indexCat($id,ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCategorie($id),
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
        ]);
    }

}
