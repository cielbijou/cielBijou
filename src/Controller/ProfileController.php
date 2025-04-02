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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil_index', methods: ['GET'])]
    public function index(): Response
    {
        $profil = $this->getUser();

        return $this->render('profil/index.html.twig', [
            'profil' => $profil,
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
                // Dossier où les photos sont stockées
                $photosDirectory = $params->get('photos_directory'); // défini dans services.yaml

                // Créez un nom unique pour le fichier
                $filename = uniqid() . '.' . $photoFile->guessExtension();

                try {
                    // Déplacez le fichier dans le dossier approprié
                    $photoFile->move(
                        $photosDirectory,
                        $filename
                    );

                    // Enregistrez uniquement le chemin relatif dans la base de données
                    $utilisateur->setPhoto('uploads/photos/' . $filename);  // Chemin relatif

                } catch (FileException $e) {
                    // Si une erreur survient lors de l'upload de l'image, afficher un message d'erreur
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                    return $this->redirectToRoute('profil_editinfo');
                }
            } elseif (!$photoFile) {
                // Si aucune nouvelle photo n'est téléchargée, on garde la photo actuelle (aucune modification)
                // Vous pouvez aussi gérer un cas où vous voulez supprimer la photo existante
                // $utilisateur->setPhoto(null); // Si vous voulez supprimer la photo
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



    #[Route('/edit/password', name: 'edit_password', methods: ['GET'])]
    public function editPassword(): Response
    {
        $profil = $this->getUser();
        return $this->render('profil/editPassword.html.twig', [
            'profil' => $profil,
        ]);
    }

    #[Route('/edit/password/{newPassword}/{oldPassword}/{password2}', name: 'edit_password_confirmation', methods: ['GET'])]
    public function editPasswordConfirmation(EntityManagerInterface $entityManager,$password2, $newPassword, ClientRepository $clientRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $profil = $this->getUser();
        if($newPassword == $password2 && $profil){
            $user = $entityManager->getRepository(Client::class)->find($profil->getId());
            $newPassword = $userPasswordHasher->hashPassword($user, $newPassword);
            $user->setPassword($newPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('profil/index.html.twig', [
                'profil' => $profil,
            ]);
        }else{
            return $this->render('profil/editPassword.html.twig', [
                'profil' => $profil,
            ]);
        }
    }




      
}
