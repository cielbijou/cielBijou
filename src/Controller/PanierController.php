<?php

namespace App\Controller;

use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProduitRepository $prodRepo): Response
    {

        $panier = $session->get('panier', []);
        $panierAvecDonnee=[];
        foreach($panier as $id => $quantite){
            $panierAvecDonnee[] = ['produit'=>$prodRepo->find($id), 'qte'=>$quantite];
        }



        return $this->render('panier/index.html.twig', [
            'items' => $panierAvecDonnee,
        ]);
    }


    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function add($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id]))
            $panier[$id]++;
        else
            $panier[$id]=1;
        $session->set('panier', $panier);
        $this->addFlash('panier', 'produit ajouté au panier');

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return $this->redirectToRoute('catalogue', [], RESPONSE::HTTP_SEE_OTHER);
    }

    public function nbProdPanier(SessionInterface $session){
        $panier = $session->get('panier', []);
        $total=0;
        foreach($panier as $id => $quantite){
            $total = $total+$quantite;
        }
        return $total;
    }

    #[Route('/panier/plus/{id}', name: 'panier_plus')]
    public function plus($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id]))
            $panier[$id]++;

        $session->set('panier', $panier);
        $this->addFlash('panier', 'Vous avez ajouté une unité du produit dans votre commande');

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return $this->redirectToRoute('panier', [], RESPONSE::HTTP_SEE_OTHER);


    }

    #[Route('/panier/moins/{id}', name: 'panier_moins')]
    public function moins($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])){
            $panier[$id]--;
            if($panier[$id]==0) unset($panier[$id]);
        }
        $session->set('panier', $panier);
        $this->addFlash('panier', 'Vous avez enlevé une unité du produit dans votre commande');

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return $this->redirectToRoute('panier', [], RESPONSE::HTTP_SEE_OTHER);


    }

    #[Route('/panier/remove/{id}', name: 'panier_remove')]
    public function remove($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        $this->addFlash('panier', 'Le produit a été supprimer de votre panier');

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return $this->redirectToRoute('panier', [], RESPONSE::HTTP_SEE_OTHER);


    }
}
