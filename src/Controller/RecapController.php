<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Commande;
use App\Entity\Commandeligne;
use App\Form\ChoisirLivraisonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }
    #[Route('/compte/recap/{adrL}/{adrF}', name: 'recap')]
    public function index($adrL, $adrF, Panier $panier, Request $request): Response
    {
        $transporter = null;
        $formTransporter = $this->createForm(ChoisirLivraisonType::class);
        $formTransporter->handleRequest($request);
        if($formTransporter->isSubmitted() && $formTransporter->isValid()){
            $transporter = $formTransporter->get('transporteurs')->getData();
            // preparaton des donnees
            $date = new \DateTimeImmutable();
            $reference = $date->format('dmY').'-'.uniqid(); 
            // preparation de la commande 
            $commande = new Commande();
            $commande->setAdrLivraison($adrL);
            $commande->setAdrFacturation($adrF);
            $commande->setUser($this->getUser());
            $commande->setCreatedAt($date);
            $commande->setReference($reference);
            $commande->setTsociete($transporter->getNameSociety());
            $commande->setTprix($transporter->getPriceSociety());
            $commande->setIsFinalized(0);
            $this->emi->persist($commande);
            // preparation des lignes de commandes
            foreach($panier->afficherTout() as $product){
                //creer un objet vide de commandeligne
                $cmdLigne = new Commandeligne();
                $cmdLigne->setCommande($commande);
                $cmdLigne->setProductName($product['product']->getName());
                $cmdLigne->setProductQuantite($product['qty']);
                $cmdLigne->setProductPrice($product['product']->getPrice() / 100);
                $cmdLigne->setTotal(($product['product']->getPrice() / 100) * $product['qty']);
                $this->emi->persist($cmdLigne);
            }
            $this->emi->flush();
        }

        return $this->render('recap/recap.html.twig',[
            'adrL' => $adrL,
            'adrF' => $adrF,
            'panier' => $panier->afficherTout(),
            'transport' => $transporter,
            'reference' => $reference
        ]);
    }
}
