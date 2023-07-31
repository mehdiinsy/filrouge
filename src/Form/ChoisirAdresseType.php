<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoisirAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user']; //recup l'utilisateur en cours
        $builder
            ->add('adresseLivraison', EntityType::class, [
                'label' => 'choisissez votre adresse de livraison',
                'required' => true,
                'class' => Adresse::class,
                'choices' => $user->getAdresses(),
                'multiple' => false,
            ])

            ->add('adresseFacturation', EntityType::class, [
                'label' => 'choisissez votre adresse de facturation',
                'required' => true,
                'class' => Adresse::class,
                'choices' => $user->getAdresses(),
                'multiple' => false,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valid my adresses',
                'attr' => [
                    'class' => 'd-block mx-auto btn btn-success'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user' => array()
        ]);
    }
}