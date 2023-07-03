<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle', TextType::class, [
            'label' => 'Libelle',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez le libelle min 2 caractere'
            ]
        ])


        ->add('prenom', TextType::class, [
            'label' => 'Prenom',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre prenom min 2 caractere'
            ]
        ])
        
        ->add('nom', TextType::class, [
            'label' => 'nom',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre nom min 2 caractere'
            ]
        ])
        
        ->add('textAdresse', TextType::class, [
            'label' => 'Adresse',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre adresse min 2 caractere'
            ]
        ])
        
        
        ->add('societe', TextType::class, [
            'label' => 'Societe',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez le nom de votre societe min 2 caractere'
            ]
        ])


        ->add('phone', TelType::class, [
            'label' => 'Phone',
            'attr' => [
                'placeholder' => 'saisissez votre numero de telephone '
            ]
        ])

        ->add('cp', TextType::class, [
            'label' => 'Code postal',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre code postal min 2 caractere'
            ]
        ])
        
        ->add('ville', TextType::class, [
            'label' => 'Ville',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre ville min 2 caractere'
            ]
        ])
        
        ->add('pays', CountryType::class, [
            'label' => 'Pays',
            'attr' => [
            ]
        ])

        ->add('submit', SubmitType::class, [
            'label' => "s'inscrire",
        ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
