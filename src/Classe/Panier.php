<?php
namespace App\Classe;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

Class Panier
{
//preparer toutes les fonctions necessaires pour gerer la session RequestStack
private $emi;
private $rs;

public function __construct(EntityManagerInterface $emi, RequestStack $rs)
{
    $this->emi = $emi;
    $this->rs = $rs;
}
public function ajouter($id){
    // creer une sauvegarde vers la session ou vers le panier dans la session
    $panier = $this->rs->getSession()->get('panier', []);
    if(!empty($panier[$id])){
        //augmenter la quantite d'un article existant dans le panier
        $panier[$id]++;
    }else{
        //ajouter un nouvel article dans le panier
        $panier[$id] = 1;
    }
    $this->rs->getSession()->set('panier', $panier);
    
}
    //$this->rs->set('panier', [...])
    // la structure de l'entree 'panier' dans la session 
    // panier [
    //     'id' => 'qty' (par defaut la quantite commandee = 1)
    // ]
    // la structure de la table 'panier' sous symfony 
    // panier [
    //     'product[]' => 'qty' (par defaut la quantite commandee = 1)
    // ]


    //convertir le panier de la session en une table pour l'afficher
    public function afficherTout(){
        $panier_twig = [];
        if($this->afficher()){ //le panier de la session n'est pas vide
            foreach($this->afficher() as $id=>$qty){
                $obj = $this->emi->getRepository(Product::class)->find($id);
                if(!$obj){
                    $this->supprimer($id);
                    continue;
                }else{
                    $panier_twig[] = [
                        'product' => $obj,
                        'qty' =>$qty
                    ];
                }
            }
            return $panier_twig;
        }
    }


    public function afficher(){
        return $this->rs->getSession()->get('panier');
    }
    public function supprimer($id){
        $panier = $this->rs->getSession()->get('panier', []);
        unset($panier[$id]);
        $this->rs->getSession()->set('panier', $panier);
    }
    public function vider(){
        return $this->rs->getSession()->remove('panier');

    }
    public function reduire($id){
        $panier = $this->rs->getSession()->remove('panier', []);
        if($panier[$id] == 1){
            unset($panier[$id]);
        }else{
            $panier[$id]--;
        }
        return $this->rs->getSession()->set('panier', $panier);
    }

}

?>