<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function index(SessionInterface $session, ProduitRepository $prodRepo, ClientRepository $client, Security $security): Response
    {
        $panier = $session->get('panier', []);
        if(count($panier)==0){
            $this->addFlash('panier', 'Le panier est vide');
            return $this->redirectToRoute('panier', [], Response::HTTP_SEE_OTHER);
        }
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $panierAvecDonnee=[];
        foreach($panier as $id => $quantite){
            $panierAvecDonnee[] = ['produit'=>$prodRepo->find($id), 'qte'=>$quantite];
        }
        // $user = $security->getUser();

        return $this->render('commande/index.html.twig', [
            'items' => $panierAvecDonnee,
            // 'donneCli' => $client->find($user),
        ]);
    }


    #[Route('/valider', name: 'commande_valider')]
    public function add(SessionInterface $session, ProduitRepository $ProdRepo, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $panier = $session->get('panier', []);

        $cde = new Commande();
        $cde->setDateCommande(new \DateTime());
        $cde->setUnClient($this->getUser());

        foreach($panier as $id =>$quantite){
            $cdeLC = new LigneCommande();
            $cdeLC->setQuantite($quantite);
            $cdeLC->setUneCommande($cde);
            $cdeLC->setUnProduit($ProdRepo->find($id));
            $entityManager->persist($cdeLC);
        }
        $entityManager->persist($cde);
        $entityManager->flush();
        $this->addFlash('panier', 'Merci pour votre commande');
        $session->set('panier', []);
        $session->set('nbproduitpanier', 0);
        return $this->redirectToRoute('panier', [], Response::HTTP_SEE_OTHER);
    }
}
