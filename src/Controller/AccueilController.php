<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'collection' => $produitRepository->findByCielBijouCollection2(),
        ]);
    }
}
