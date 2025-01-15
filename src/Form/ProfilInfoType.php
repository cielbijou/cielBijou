<?php
namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', TextType::class, [
            'disabled' => true,  // Le champ email ne peut pas être modifié par l'utilisateur
            'attr' => ['class' => 'form-control'],
        ])
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('photo', FileType::class, [
            'required' => false,
            'mapped' => false,  // Le champ photo n'est pas mappé directement sur l'entité
            'label' => 'Votre photo de profil',
            'attr' => ['accept' => 'image/*'], 
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
