<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LigneCommandeRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{

    #[Route('/Commande', name: 'contact_index')]
    public function index(CommandeRepository $commandeRepository,LigneCommandeRepository $ligneCommandeRepository,ProduitRepository $produitRepository, EntityManagerInterface $em, CommandeRepository $cmd): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->addFlash('error', 'Vous ne pouvez pas accéder à cette page car vous n\'avez pas de réservation.');
            return $this->redirectToRoute('catalogue');
        }

        
        $userEmail = $user->getUserIdentifier();

        
        $client = $em->getRepository(Client::class)->findOneBy(['email' => $userEmail]);

        if ($client === null) {
            $this->addFlash('error', 'Client non trouvé.');
            return $this->redirectToRoute('catalogue');
        }

        
        $commandes = $cmd->findByUser($client);
        $nbr_commandes = count($commandes);



        $produits = []; 
        $commandes = $commandeRepository->findByUser($user); 
        
        foreach ($commandes as $commande) {
            $produitsParCommande = [];
            $ligneCommandes = $ligneCommandeRepository->findProduitCommande($commande);
            foreach ($ligneCommandes as $ligneCommande) {
                $produitsParCommande[] = $ligneCommande->getUnProduit();
            }
            $produits[] = $produitsParCommande;
        }
        return $this->render('contact/index.html.twig', [
            'nbr_commandes' => $nbr_commandes,
            'commandes' => $commandes,
            'prod' => $produits,
        ]);
    }

    #[Route('/contact/detail/soumettre', name: 'soumettre_avis', methods: ['POST'])]
    public function soumettreAvis(Request $request, Security $security, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $produitId = $request->request->get('produitId');
        $commentaire = $request->request->get('commentaire');
        $rating = $request->request->get('rating');
        if ($commentaire && $rating) {
            $produit = $produitRepository->find($produitId);
    
            if ($produit) {
                $enregistrement = new Commentaire();
                $enregistrement->setDateCommentaire(new \DateTime());
                $enregistrement->setContenuCommentaire($commentaire);
                $enregistrement->setNoteCommentaire((int) $rating);
                $enregistrement->setUnClient($security->getUser());
                $enregistrement->setUnProduit($produit);
                $enregistrement->setStatusCommentaire('Non Traité');
    
                // Sauvegarder le commentaire dans la base de données
                $entityManager->persist($enregistrement);
                $entityManager->flush();

                $this->addFlash('panier', 'Votre avis a bien été soumis !');
            } else {
                $this->addFlash('error', 'Produit non trouvé.');
            }
        } else {
            $this->addFlash('error', 'Veuillez remplir le commentaire et la note.');
        }
    
        return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
    }
    

    #[Route('/contact/detail/{id}', name: 'contact_detail')]
    public function detail($id, CommandeRepository $commandeRepository, ProduitRepository $produitRepository, LigneCommandeRepository $ligneCommandeRepository, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $produits = []; 
        $produits = $ligneCommandeRepository->findProduitCommande((int)$id);
        return $this->render('contact/detail.html.twig', [
            'prod' => $produits,
            'commande' => $id,
        ]);
    }

    
    #[Route('/contact', name: 'contact')]
    public function Contact(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $unContact = new Contact();
        $form = $this->createForm(ContactType::class, $unContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('ok', 'Votre demande a été engegistrer. Nous vous répondrons rapidement');

            $mail = new Email();
            $mail->subject("Demande d'informations")
                ->from(new Address('noreply@noreply.fr', 'ElecMob'))
                ->to('projet.cielbijou@gmail.com', $unContact->getEmail())
                -> replyTo(new Address('noreply@noreply.fr', 'Ne pas répondre'))
                ->html(
                    $this->renderView('contact/mail.html.twig', [
                        'unContact' =>$unContact
                    ]), 'text/html'
                )
            ;
            try{
                $mailer->send($mail);
                $this->addFlash('contact', 'Email de confirmation envoyé avec succès');
            }catch(TransportExceptionInterface $e){
                $this->addFlash('contact', 'unProblème a eu lieu durent l\'envoi, veuillez re-essayer');
            }

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/formulaire.contact.html.twig', ['formContact' => $form->createView(),]);
    }


}
