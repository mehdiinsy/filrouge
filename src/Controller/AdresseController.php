<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi=$emi;
    }
    #[Route('/compte/adresse/ajouter', name: 'ajouterAdresse')]
    public function index(Request $request): Response
    {
        $adr = new Adresse();
        $form = $this->createForm(AdresseType::class, $adr);
        //ecouter le submit

        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //recup l'utilisateur en cours
            $currentUser = $this->getUser();
            //placer l'utilisateur en cours  dans user de l'adresse setter
            // $adr-> $this->getUser();
            $adr->setUser($currentUser);
            //figer les donnees a renvoyer vers la bdd
            $this->emi->persist($adr);
            //maj dans la bdd
            $this->emi->flush();
            return $this->redirectToRoute('mesAdresse');

        }
        return $this->render('adresse/gestionAdresse.html.twig', [
            'formAdresse' => $form->createView()
        ]);
    }
    #[Route('/mesAdresse', name: 'mesAdresse')]
    public function index1(Request $request): Response
    {
        return $this->render('adresse/mesAdresse.html.twig');
}

#[Route('/compte/adresse/supprimer/{id}', name: 'supprimerAdresse')]
    public function index2($id): Response
    {
        $adr= $this->emi->getRepository(Adresse::class)->find($id);
        //verifier si l'adresse existe et l'utilisateur en cours est son proprio
        if($adr && ($this->getUser() == $adr->getUser())){
            $this->emi->remove($adr);
            $this->emi->flush();

        }
        return $this->redirectToRoute('mesAdresse');


}

#[Route('/compte/adresse/modifier/{id}', name: 'modifierAdresse')]
    public function index3($id, Request $request): Response
    {
        $adr= $this->emi->getRepository(Adresse::class)->find($id);
        //verifier si l'adresse existe et l'utilisateur en cours est son proprio
        if($adr && ($this->getUser() == $adr->getUser())){
            $this->emi->flush();
            return $this->redirectToRoute('mesAdresse');


        }
        $form = $this->createForm(AdresseType::class,$adr);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->emi->flush();
            return $this->redirectToRoute('mesAdresse');
        }
        return $this->render('adresse/gestionAdresse.html.twig', [
            'formAdresse' =>$form->createView()
        ]);
}


}