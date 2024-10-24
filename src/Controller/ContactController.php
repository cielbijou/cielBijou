<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/contact/detail/soumettre', name: 'soumettre_avis')]
    public function soumettreAvis(Request $request, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $produitId = $request->request->get('produitId');
        $commentaire = $request->request->get('commentaire');
        $rating = $request->request->get('rating');
        if ($commentaire && $rating) {
            $enregistrement = new Commentaire();
            $enregistrement->setDateCommentaire(new \DateTime());
            $enregistrement->setContenuCommentaire($commentaire);
            $enregistrement->setNoteCommentaire($rating);
            $enregistrement->setUnClient($security->getUser());
            $enregistrement->setUnProduit($produitId);
            $enregistrement->setStatusCommentaire('Non Traité');
            $this->addFlash('success', 'Votre avis a bien été soumis !');
        }
        return $this->redirectToRoute('accueil');
    }
    
}
