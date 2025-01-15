<?php

namespace App\Controller;

use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Length;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProduitRepository $prodRepo): Response
    {

        $panier = $session->get('panier', []);
        $panierAvecDonnee=[];
        foreach($panier as $id => $quantite){
            $produit = $prodRepo->findPanier($id);
            if(!empty($produit))
                $panierAvecDonnee[] = ['produit'=>$prodRepo->findPanier($id), 'qte'=>$quantite];
            else
                $panierAvecDonnee[] = ['produit'=>$prodRepo->findById($id), 'qte'=>$quantite];
        }

        return $this->render('panier/index.html.twig', [
            'items' => $panierAvecDonnee,
        ]);
    }

    
    #[Route('/panier/vider', name: 'panier_vider')]
    public function vider(SessionInterface $session): Response
    {
        $session->set('panier', []);
        $this->addFlash('success', 'Le panier a été vidé.');
        $session->set('nbproduitpanier', 0);
        return $this->redirectToRoute('panier', [], Response::HTTP_SEE_OTHER);
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

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return new Response($this->nbProdPanier($session));

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

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return new Response($this->nbProdPanier($session));


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

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return new Response($this->nbProdPanier($session));


    }

    #[Route('/panier/remove/{id}', name: 'panier_remove')]
    public function remove($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier', $panier);

        $session->set('nbproduitpanier', $this->nbProdPanier($session));

        return new Response($this->nbProdPanier($session));


    }
}
