<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('', name: 'accueil')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'collection' => $produitRepository->findByCielBijouCollection2(),
        ]);
    }

    #[Route('/mentions', name: 'accueil_mentions')]
    public function mentionLegales(): Response
    {
        return $this->render('accueil/mentionsLegales.html.twig', [
            'mentions' => '',
        ]);
    }

    #[Route('/conditions', name: 'accueil_conditions')]
    public function conditionsGenerale(): Response
    {
        return $this->render('accueil/conditions.html.twig', [
            'conditions' => '',
        ]);
    }
}
