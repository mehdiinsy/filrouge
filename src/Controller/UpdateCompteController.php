<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UpdateCompteController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi=$emi;
    }
    #[Route('/UpdateCompte', name: 'UpdateCompte')]
    public function index(Request $request, UserPasswordHasherInterface $uphi): Response
    {
        $notif = null;
        //recup utilisateur en cours
        $user = $this->getUser();
        $form = $this->createForm(UpdateCompteType::class, $user);
        //ecouter le submit

        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // recup mdp actuel depuis le formulaire
            $actualPassword = $form->get('oldPassword')->getData();
            //tester si mdp actuel conforme au mdp de user connecte
            if($uphi->isPasswordValid($user, $actualPassword)){
                //recup nvx mdp depuis form
                $newPassword = $form->get('newPassword')->getData();
                //crytpe nvx mdp
                $pwd = $uphi->hashPassword($user, $newPassword);
                //placer nvx mdp dans $user
                $user->setPassword($pwd);
                
                //persist pas obligatoire si modif
                $this->emi->persist($user);
                $this->emi->flush();
                $notif = "!! Bravo modification réussie";
            }else{
                $notif = "Oups il y a une erreur";
            }            
        }
        return $this->render('compte/UpdateCompte.html.twig', [
            'formUpdate' => $form->createView(),
            'notif' => $notif
        ]
        );
    }
}
