<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{

    private function getSortOrder(string $ordre): string
    {
        return match ($ordre) {
            'croissant' => 'ASC',  
            'decroissant' => 'DESC', 
            default => 'ASC', 
        };
    }


    #[Route('', name: 'accueil')]
    public function index(Request $request, ProduitRepository $produitRepository): Response
    {
        $order = $request->request->get('ordre', 'croissant');
        if($order == null)
            $order='croissant';
        $sortOrder = $this->getSortOrder($order); // 'ASC' ou 'DESC'
        $prod = $produitRepository->findByCielBijouCollection2($sortOrder);
        return $this->render('accueil/index.html.twig', [
            'collection' => $prod,
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
