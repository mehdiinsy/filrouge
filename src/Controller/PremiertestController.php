<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PremiertestController extends AbstractController
{
    #[Route('/premiertest', name: 'app_premiertest')]
    public function index(): Response
    {
        $name = "Marco";
        $adresse = "31 rue sphynx";
        return $this->render('premiertest/index.html.twig', [
            'controller_name' => 'PremiertestController',
            "nom" => $name,
            "adr" => $adresse
        ]);
    }
}
