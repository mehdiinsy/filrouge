<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PremiertestController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $name = "Marco";
        $adresse = "31 rue sphynx";
        
        return $this->render('home/home.html.twig', [
            'controller_name' => 'PremiertestController',
            "nom" => $name,
            "adr" => $adresse
        ]);
    }
}
