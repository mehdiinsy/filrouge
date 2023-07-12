<?php

namespace App\Form;

use App\Entity\Transporter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoisirLivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $builder
            ->add('transporteurs', EntityType::class, [
                'label' => ' ',
                'required' => true,
                'class' => Transporter::class,
                'multiple' => false,
                'expanded' => true,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider ma livraison',
                'attr' => [
                    'class' => 'btn btn-success'
                ] 
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
