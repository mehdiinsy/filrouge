<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdresseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adresse::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Libelle'),
            TextField::new('Prenom'),
            TextField::new('Nom'),
            TextareaField::new('textAdresse'),
            TextField::new('Societe'),
            TelephoneField::new('Phone'),
            TextField::new('cp'),
            TextField::new('Ville'),
            TextField::new('Pays')
        ];
    }
    // public function configureActions(Actions $actions): Actions
    // {
    //     return $actions->remove(Crud::PAGE_INDEX, Action::NEW);
    // }
    
}
