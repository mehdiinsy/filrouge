<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        //ecouter le submit

        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //recup le donnees du form
            $user = $form->getData();
            //figer les donnees a renvoyer vers la bdd
            $this->em->persist($user);
            //maj dans la bdd
            $this->em->flush();
        }
        return $this->render('inscription/inscription.html.twig', [
            'formInscription' => $form->createView()
        ]);
    }
}
