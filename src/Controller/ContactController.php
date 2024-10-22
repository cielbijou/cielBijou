<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(CommandeRepository $commandeRepository, ProduitRepository $produitRepository, LigneCommandeRepository $ligneCommandeRepository, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $commande = $commandeRepository->findBy(['user' => $security->getUser()]);
        $produit = [];
    
        foreach ($commande as $com) {
            $ligneCommandes = $ligneCommandeRepository->findBy(['commande' => $com]);
            foreach ($ligneCommandes as $ligneCommande) {
                $produit[] = $produitRepository->find($ligneCommande->getProduit()->getId());
            }
        }
    
        return $this->render('contact/index.html.twig', [
            'commande' => $commande,
            'produit' => $produit,
        ]);
    }

    #[Route('/contact/detail/{$id}', name: 'contact_detail')]
    public function detail($id, CommandeRepository $commandeRepository, ProduitRepository $produitRepository, LigneCommandeRepository $ligneCommandeRepository, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $commande = $commandeRepository->findBy(['user' => $security->getUser()]);
        $produit = [];
        foreach ($commande as $com) {
            $ligneCommandes = $ligneCommandeRepository->findBy(['commande' => $com]);
            foreach ($ligneCommandes as $ligneCommande) {
                $produit[] = $produitRepository->find($ligneCommande->getProduit()->getId());
            }
        }
    
        return $this->render('contact/detail.html.twig', [
            'produit' => $produit,
            'commande' => $commandeRepository->find($id),
        ]);
    }
    
}
