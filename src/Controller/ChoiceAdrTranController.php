<?php

namespace App\Controller;

use App\Form\ChoisirAdresseType;
use App\Form\ChoisirLivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChoiceAdrTranController extends AbstractController
{
    #[Route('/compte/choisir/adresse', name: 'choisirAdresse')]
    public function index(): Response
    {
        $form = $this->createForm(ChoisirAdresseType::class, null, [
            'user' => $this->getUser()
        ]);
        return $this->render('choice/choisirAdresse.html.twig', [
            'f' => $form->createView()
        ]);
        
        
    }
    
    #[Route('/compte/transporteur', name: 'choisirTransporteur')]
    public function choisirTransporteur(Request $request): Response
    {
        $adrL = null;
        $adrF = null;
        $formAdresse = $this->createForm(ChoisirAdresseType::class, null, [
            'user' => $this->getUser()
        ]);
        $formAdresse->handleRequest($request);
        
        if($formAdresse->isSubmitted() && $formAdresse->isValid()){
            $adrL = $formAdresse->get('adresseLivraison')->getData();
            $adrF = $formAdresse->get('adresseFacturation')->getData();
        }
        $form = $this->createForm(ChoisirLivraisonType::class);

        return $this->render('choice/choiceDelivery.html.twig', [
            'f' => $form->createView(),
            'adrL' => $adrL,
            'adrF' => $adrF,
        ]);
        
    }
}
