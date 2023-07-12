<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index($reference): Response
    {
        $ref = str_replace('%20','',$reference);
        $sessionProducts = []; // on va sauvegarder les produits de notre commande

        $YOUR_DOMAIN = "http://127.001:8000";
        $commande = $this->emi->getRepository(Commande::class)->findOneBy(['reference' => $reference]);
        // remplir le tableau sessionProducts
        foreach($commande->getCommandeLignes()->getValues() as $product){
            $prod = $this->emi->getRepository(Product::class)
            ->findOneBy(['name' => $product->getProductName()]);
            $sessionProducts[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getProductPrice() * 100,
                    'product_data' => [
                        'name' => $product->getProductName(),
                        'images' => ["assets/img/products/images/".$prod->getImage()]
                    ]
                    ],
                    'quantity' => $product->getProductQuantite()
                ];

        }
        // ajouter les frais de livraison
        $sessionProducts[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $commande->getTprix()* 100,
                'product_data' => [
                    'name' => $commande->getTsociete(),
                    'images' => [$YOUR_DOMAIN]
        ]
                ],
                'quantity' => 1
            ];
            //utilisation de la cle secrete stripe
            Stripe::setApiKey('sk_test_51NT3M7JHodYJkToyGvRiK71Wu7a1IPOhwYKOH5b5QulTUh5HI7vcbwW6qiuFFUZQICWpFFO74QCoNF8ZMWIsBshu00jaGZr9RW');
            // creation de la session checkout
            $checkout_session = Session::create([
                'customer_email' => $this->getUser()->getEmail(),
                'payment_method_types' => ['card'],
                'line_items' => [$sessionProducts],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . "/commande/success/{CHECKOUT_SESSION_ID}",
                'cancel_url' => $YOUR_DOMAIN . "/cancel.html"
            ]);
            $sessionId = $checkout_session->id;
            $commande->setStripeId($sessionId);
            $this->emi->flush();

            $response = new JsonResponse(['id' => $sessionId]);
            return $response;

    }
}
