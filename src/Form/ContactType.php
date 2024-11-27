<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('profession')
            ->add('email')
            ->add('objet', ChoiceType::class, [
                    'choices' => [
                    '' => null,
                    'Demande de renseignements sur un produit' => 'Demande de renseignements sur un produit',
                    'Demande de renseignements sur le magasin' => 'Demande de renseignements sur le magasin',
                    'Service après-vente' => 'Service après-vente'],])
            ->add('message')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
