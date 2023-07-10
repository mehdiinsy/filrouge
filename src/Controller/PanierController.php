<?php

namespace App\Controller;

use App\Classe\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier->afficherTout()
        ]);
    }
    #[Route('/panier/ajouter/{id}', name: 'ajouterPanier')]
    public function ajouterPanier(Panier $panier, $id): Response
    {
        $panier->ajouter($id);
        return $this->redirectToRoute('panier');
        
    }
}
