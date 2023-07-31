<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from(new Address('mehdi-belkateb@hotmail.com'))
            ->to('sedki.benali@kn-consulting.fr')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Hello world')
            ->text('Sending emails is fun again!')
            ->html('<h1>Congratulations !</h1><p>You have just successfully registered on the best car import site !</p>');
        try {
            $mailer->send($email);
        } 
        catch (TransportExceptionInterface $e) {
            var_dump('error test');
        }
        // ...
        return $this->render('/mailer/mail.html.twig');
        // return new Response('Email was sent!');
    }
}

//php bin/console messenger:consume async /!\ taper cette commande pour recevoir les mail /!\
//Symfony\Component\Mailer\Messenger\SendEmailMessage: async /!\ ou bien commenter cette commande dans messenger.yaml /!\