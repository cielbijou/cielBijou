<?php

namespace App\Controller;

use App\Entity\Promotion;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\PromotionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

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
            $moyenne = ceil($moyenne); 
            $result[] = [
                'produitId' => $produit->getId(),
                'note' => $moyenne,
            ];
        }
    
        return $result;
    }

    private function getSortOrder(string $ordre): string
    {
        return match ($ordre) {
            'croissant' => 'ASC',  
            'ASC' => 'ASC', 
            'DESC' => 'DESC', 
            'decroissant' => 'DESC',
            default => 'ASC', 
        };
    }
    
    #[Route('/catalogue', name: 'catalogue')]
    public function index(Request $request,PromotionRepository $promotionRepository ,CommentaireRepository $commentaireRepository, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $order = $request->request->get('ordre', 'croissant');
        $sortOrder = $this->getSortOrder($order);
        $prod = $produitRepository->findByPrix($sortOrder);
    
        return $this->render('catalogue/index.html.twig', [
            'produits' => $prod,
            'categories' => $categorieRepository->findAll(),
            'promo' => $promotionRepository->getCategoriePromo(),
            'notes' => $this->Notation(),
            'commentaire'=>$commentaireRepository->findCommentaireProduit(),
        ]);
    }

    #[Route('/catalogue/CielBijou', name: 'catalogue_CielBijou')]
    public function indexCielBijou(Request $request,PromotionRepository $promotionRepository ,CommentaireRepository $commentaireRepository, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        
        $order = $request->request->get('ordre', 'croissant');
        $sortOrder = $this->getSortOrder($order);
        $produits = $produitRepository->findByCielBijou($sortOrder);

        return $this->render('catalogue/index.html.twig', [
            'produits' => $produits,
            'categories' => $categorieRepository->findAll(),
            'promo' => $promotionRepository->getCategoriePromo(),
            'notes' => $this->Notation(),
            'commentaire'=>$commentaireRepository->findCommentaireProduit(),
        ]);
    }

    #[Route('/catalogue/CielBijou/Collection1', name: 'catalogue_Collection1')]
    public function indexCollection1(Request $request,PromotionRepository $promotionRepository ,CommentaireRepository $commentaireRepository,ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        $order = $request->request->get('ordre', 'croissant');
        $sortOrder = $this->getSortOrder($order);
        $prod = $produitRepository->findByCielBijouCollection1($sortOrder);
        return $this->render('catalogue/index.html.twig', [
            'produits' => $prod,
            'categories' => $categorieRepository->findAll(),
            'promo' => $promotionRepository->getCategoriePromo(),
            'notes' => $this->Notation(),
            'commentaire'=>$commentaireRepository->findCommentaireProduit(),
        ]);
    }

    #[Route('/catalogue/CielBijou/Collection2', name: 'catalogue_Collection2')]
    public function indexCollection2(Request $request,PromotionRepository $promotionRepository ,CommentaireRepository $commentaireRepository, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $order = $request->request->get('ordre', 'croissant');
        $sortOrder = $this->getSortOrder($order); // 'ASC' ou 'DESC'
        $prod = $produitRepository->findByCielBijouCollection2($sortOrder);

        return $this->render('catalogue/index.html.twig', [
            'produits' => $prod,
            'categories' => $categorieRepository->findAll(),
            'promo' => $promotionRepository->getCategoriePromo(),
            'notes' => $this->Notation(),
            'commentaire'=>$commentaireRepository->findCommentaireProduit(),
        ]);
    }

    
    #[Route('/catalogue/CielBijou/Promotion', name: 'catalogue_Promotion')]
    public function indexPromotion(Request $request,CommentaireRepository $commentaireRepository, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $order = $request->request->get('ordre', 'croissant');
        $sortOrder = $this->getSortOrder($order); 
        $produits =  $produitRepository->getPromotion($sortOrder);
        return $this->render('catalogue/promo.html.twig', [
            'produits' => $produits,
            'categories' => $categorieRepository->findAll(),
            'notes' => $this->Notation(),
            'commentaire'=>$commentaireRepository->findCommentaireProduit(),
        ]);
    }

    #[Route('/catalogue/{id}', name: 'catalogue_cat')]
    public function indexCat($id,Request $request,PromotionRepository $promotionRepository ,CommentaireRepository $commentaireRepository,ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {   
        $order = $request->request->get('ordre', 'croissant');
        $sortOrder = $this->getSortOrder($order);
        $prod = $produitRepository->findByCategorie($id, $sortOrder);
        return $this->render('catalogue/index.html.twig', [
            'produits' => $prod,
            'categories' => $categorieRepository->findAll(),
            'promo' => $promotionRepository->getCategoriePromo(),
            'notes' => $this->Notation(),
            'commentaire'=>$commentaireRepository->findCommentaireProduit(),
        ]);
    }

}
