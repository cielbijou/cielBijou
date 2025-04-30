<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ProfilInfoType;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LigneCommandeRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil_index', methods: ['GET'])]
    public function index(): Response
    {
        $profil = $this->getUser();
        $photoData = null;
        if($profil->getPhoto()){
            $photo = $profil->getPhoto();
            if (is_resource($photo)) {
                $photoData = stream_get_contents($photo);
            } elseif (is_string($photo)) {
                $photoData = $photo;
            }
            
            if ($photoData) {
                $photoData = base64_encode($photoData);
            }
        }
        return $this->render('profil/index.html.twig', [
            'profil' => $profil,
            'photoData' => $photoData,
        ]);
    }
    
    #[Route('/editinfo', name: 'profil_editinfo', methods: ['GET', 'POST'])]
    public function editInfo(Request $request, EntityManagerInterface $entityManager, ParameterBagInterface $params): Response
    {
        $utilisateur = $this->getUser();
        $form = $this->createForm(ProfilInfoType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();  // Récupère l'objet UploadedFile depuis le formulaire

            if ($photoFile) {
                try {
                    // Lire le contenu binaire du fichier téléchargé
                    $photoData = file_get_contents($photoFile->getPathname());
            
                    // Enregistre le contenu binaire dans le champ 'photo' de l'utilisateur
                    $utilisateur->setPhoto($photoData);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors du traitement de l\'image.');
                    return $this->redirectToRoute('profil_editinfo');
                }
            }

            // Sauvegardez les modifications dans la base de données
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Redirigez vers le profil une fois l'édition effectuée
            return $this->redirectToRoute('profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/editInfo.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }


      
}
