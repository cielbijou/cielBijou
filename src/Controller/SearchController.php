<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search-suggestions", name="search_suggestions", methods={"GET"})
     */
    public function searchSuggestions(Request $request, ProduitRepository $produitRepository): JsonResponse
    {
        $query = $request->query->get('q', '');
        if (strlen($query) < 2) {
            return new JsonResponse([], 200);
        }

        $suggestions = $produitRepository->createQueryBuilder('p')
            ->where('p.nomProd LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();


        $response = array_map(function ($produit) {
            return [
                'id' => $produit->getId(),
                'nomProd' => $produit->getNomProd(),
            ];
        }, $suggestions);

        return new JsonResponse($response);
    }
}
