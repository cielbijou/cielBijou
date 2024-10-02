<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{

    private $commentaireRepository;

    public function __construct(CommentaireRepository $commentaireRepository)
    {
        $this->commentaireRepository = $commentaireRepository;
    }

    function Notation() {
        $notes = $this->commentaireRepository->findNote();
        $moyenne = 0;
        $compteur = 0;
        foreach ($notes as $note) {
            $compteur++;
            $moyenne += $note['noteCommentaire'];
        }
    
        // Calcul de la moyenne
        if ($compteur > 0) {
            $moyenne /= $compteur;
        } else {
            $moyenne = 0; 
        }
        return $moyenne;
    }
    

    #[Route('/catalogue', name: 'catalogue')]
    public function index(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'note' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou', name: 'catalogue_CielBijou')]
    public function indexCielBijou(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCielBijou(),
            'categories' => $categorieRepository->findAll(),
            'note' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou/Collection1', name: 'catalogue_Collection1')]
    public function indexCollection1(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCielBijouCollection1(),
            'categories' => $categorieRepository->findAll(),
            'note' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/CielBijou/Collection2', name: 'catalogue_Collection2')]
    public function indexCollection2(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCielBijouCollection2(),
            'categories' => $categorieRepository->findAll(),
            'note' => $this->Notation(),
        ]);
    }

    #[Route('/catalogue/{id}', name: 'catalogue_cat')]
    public function indexCat($id,ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        return $this->render('catalogue/index.html.twig', [
            'produits' => $produitRepository->findByCategorie($id),
            'categories' => $categorieRepository->findAll(),
            'note' => $this->Notation(),
        ]);
    }

}
