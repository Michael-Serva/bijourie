<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\DateFr;
use App\Service\DateBart;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{



    /**
     * La fonction catalogue permet d'afficher tous les produits de la bijouterie (FRONT OFFICE)
     * 
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(ProduitRepository $repoProduit)
    {
        // lorsqu'on créé une entity, est généré en même temps son repository
        // repository : requête SELECT




        
        // 1e façon, création de l'objet issu de la class ProduitRepository
        // on appelle la méthode getDoctrine()provenant de la class AbstractController
        // suivi de la méthode getRepository() dans laquelle en argument doit être défini la class de l'entity


        //$repoProduit = $this->getDoctrine()->getRepository(Produit::class);
        //__________________________________________________________________________________________
        // 2e façon, c'est d'appeler en argument de la fonction catalogue la class suivi de son objet
        // ===> UNE DEPENDANCE


        $produitsArray = $repoProduit->findAll();
        //$produitsArray = $repoProduit->findById(18); => tableau avec position
        //$produitsArray = $repoProduit->find(18);
        //$produitsArray = $repoProduit->findBy(["category" => 2, "prix" => 299.99]);
        //$produitsArray = $repoProduit->findTout();
        //$produitsArray = $repoProduit->findPrix(299.99);
        //$produitsArray = $repoProduit->findOrder();

        // $cat = [2,4,5];
        // $produitsArray = $repoProduit->findCategorie($cat);

        // $search = "collier";
        // $produitsArray = $repoProduit->findSearch($search);
        //$produitsArray = $repoProduit->findBetween(300,500);
        //dump($produitsArray); // s'affiche dans symfony profiler (en bas la nav noir, icône la cible)
        //dump($produitsArray);die;// s'affiche sur le navigateur car die tue la suite du code
        //dd($produitsArray); // dump die
        
        // par défaut dans le repository, il existe 4 fonctions
        // findAll() : sql : SELECT * FROM produit (sans argument)
        // find() : 1 argument, le champ id; sql : SELECT * FROM produit WHERE id = argument
        // findBy() : argument : tableau, définir le nom du champ et sa valeur, on peut en mettre plusieurs 
        // findBy(['prix' => 100, 'titre' => "bague"])


        return $this->render('produit/catalogue.html.twig', [
            "produits" => $produitsArray
        ]);
    }

    

    /**
     * la fonction fiche_produit() permet d'afficher les informations d'un produit
     * et elle a besoin d'un paramètre dans la route, 
     * {id}
     * 
     * @Route("fiche_produit/{id}", name="fiche_produit")
     */
    public function fiche_produit(Produit $produit, DateFr $dateFr, DateBart $bart)
    { //                        $id, ProduitRepository $repoProduit

        //dd($id);
        // $produit = $repoProduit->find($id);

        //dd($produit);

        $date_enregistrement = $produit->getDateAt();

        $newDate = $dateFr->moisFr4($date_enregistrement);

        $produit = $bart->mois($produit, "fr");

        //dd($dateBart);



        return $this->render('produit/fiche_produit.html.twig' , [
            "produit" => $produit
        ]);
    }


}
