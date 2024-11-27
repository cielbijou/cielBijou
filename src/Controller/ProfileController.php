<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ProfilInfoType;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil_index', methods: ['GET'])]
    public function index(): Response
    {
        $profil= $this->getUser();
        return $this->render('profil/index.html.twig', [
            'profil' => $profil,
        ]);
    }

    #[Route('/editinfo', name: 'profil_editinfo', methods: ['GET', 'POST'])]
    public function editInfo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur=$this->getUser();
        $form = $this->createForm(ProfilInfoType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/editInfo.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

}
