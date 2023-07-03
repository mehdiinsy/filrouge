<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UpdateCompteType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
        ->add('fname', TextType::class, [
            'label' => 'Prenom',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre prenom min 2 caractere'
            ]
        ])


        ->add('lname', TextType::class, [
            'label' => 'nom',
            'constraints' => new Length(2, 2, 35),
            'attr' => [
                'placeholder' => 'saisissez votre nom min 2 caractere'
            ]
        ])


        ->add('phone', TelType::class, [
            'label' => 'Tel',
            'attr' => [
                'placeholder' => 'saisissez votre numero de telephone '
            ]
        ])

        ->add('birthday', DateType::class, [
            'label' => 'Date de naissance',
            'years' => range(1920, 2010),
            'format' => 'dd-MM-yyyy'
        ])


        ->add('email', EmailType::class, [
            'label' => 'adresse mail',
            'attr' => ['placeholder' => 'saisissez votre email'],
            'disabled' => true

        ])


        ->add('oldPassword', PasswordType::class, [
            'label' => 'Mot de passe actuelle ',
            'mapped'=> false,
            'required' => true,
        ])
        
        
        ->add('newPassword', RepeatedType::class, [
            'label' => 'Mot de passe',
            'mapped'=> false,
            'type'=> PasswordType::class,
            'invalid_message' => 'mot de passe de confirmation non valide',
            'required' => true,
            'first_options' => [
                'label' => 'Nouveau mot de passe',
                'attr' => ['placeholder' => 'saisir nouveau mot de passe']
            ],
            'second_options' => [
                'label' => 'confirmation du Nouveau mot de passe',
                'attr' => ['placeholder' => 'saisir confirmation nouveau mot de passe']
            ]
        ])

        
        ->add('submit', SubmitType::class, [
            'label' => "modifier"
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
