<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\DetailsCommande;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier
{

    protected $session;
    protected $repoProduit;
    protected $manager;

    public function __construct(SessionInterface $session, ProduitRepository $repoProduit, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->repoProduit = $repoProduit;
        $this->manager = $manager;
    }





    public function creationDuPanier()
    {
        $panier = [
            'titre' => [],
            'id_produit' => [],
            'quantite' => [],
            'prix' => []
        ];

        return $panier;

        
    }

    public function add($titre, $id_produit, $quantite, $prix)
    {

        $panier = $this->session->get('panier');

        
        //dump($panier);
        if(empty($panier))
        {

            $panier = $this->creationDuPanier();
    
            $this->session->set('panier', $panier);
        }

        // ----------------------------------------------------------------
        // la structure du panier multidimensionnel est créé dans les 2 cas
        // ----------------------------------------------------------------
        
        //dd($panier);

        // fonction prédéfinie PHP array_search
        // retourne la position dans un tableau par rapport à la valeur recherché
        // si la valeur n'existe pas dans le tableau, rien n'est retourné
        // 2 arguments :
        // 1e : la valeur recherchée
        // 2e : le tableau


        $position_produit = array_search($id_produit, $panier['id_produit']);

        if($position_produit !== false) 
        {
            $panier['quantite'][$position_produit] += $quantite;
            $this->session->set('panier', $panier);
        }
        else 
        {
            $panier['titre'][] = $titre;
            $panier['id_produit'][] = $id_produit;
            $panier['quantite'][] = $quantite;
            $panier['prix'][] = $prix;

            $this->session->set('panier', $panier);
        }
        


    }

    public function remove($id_produit)
    {
        $panier = $this->session->get('panier');

        $position_produit = array_search($id_produit, $panier['id_produit']);


        if($position_produit !== false)
        {
            // fonction prédéfinie PHP
            // array_splice
            // permet de supprimer une ou plusieurs lignes dans un tableau
            // 3 arguments :
            // 1e : le tableau
            // 2e : à partir de quelle position
            // 3e : nombre d'élements à supprimer 

            array_splice($panier["titre"], $position_produit, 1);
            array_splice($panier["id_produit"], $position_produit, 1);
            array_splice($panier["quantite"], $position_produit, 1);
            array_splice($panier["prix"], $position_produit, 1);

            $this->session->set('panier', $panier);
        }

    }

    public function montantTotal()
    {
        $panier = $this->session->get('panier');
        $total = 0;

        for($i = 0; $i < count($panier['id_produit']); $i++)
        {
            if($panier["quantite"][$i] != 0)
            {
                $total += $panier["prix"][$i] * $panier["quantite"][$i];
            }
        }

        return round($total,2);
    }


    public function vider()
    {
        // $panier = $this->creationDuPanier();

        // $this->session->set('panier', $panier);

        $this->session->remove("panier");
    }
    

    public function verification()
    {
        $panier = $this->session->get('panier');

        for($i = 0; $i < count($panier['id_produit']); $i++)
        {
            $produit = $this->repoProduit->find($panier['id_produit'][$i]);

            // si le stock en bdd est inférieur à la quantité dans le panier
            if($produit->getStock() > 0 && ($produit->getStock() < $panier['quantite'][$i]))
            {
                $panier['quantite'][$i] = $produit->getStock();
            }
            // plus de stock en bdd
            elseif($produit->getStock() == 0)
            {
                $panier['quantite'][$i] = 0;
            }
        }


        $this->session->set('panier', $panier);
        return $panier;

    }



    public function payer($user)
    {
        $panier = $this->session->get('panier');
        $panier = $this->verification();


        

        $commande = new Commande;
        $commande->setUser($user);
        $commande->setMontant($this->montantTotal());
        $commande->setDateAt(new \DateTime('now'));
        $commande->setEtat(0);
        /*
            etat 0 => en cours de traitement
            etat 1 => expédié
            etat 2 => livré
        */
        $this->manager->persist($commande);
        $this->manager->flush();


        for($j = 0; $j < count($panier['id_produit']); $j++)
        {
            if($panier['quantite'][$j] != 0)
            {
                $produit = $this->repoProduit->find($panier['id_produit'][$j]);

                $detailsCommande = new DetailsCommande;
                $detailsCommande->setCommande($commande);
                $detailsCommande->setProduit($produit);
                $detailsCommande->setPrix($panier['prix'][$j]);
                $detailsCommande->setQuantite($panier['quantite'][$j]);

                $this->manager->persist($detailsCommande);
                $this->manager->flush();




                $stockBDD = $produit->getStock();
                $newStock = $stockBDD - $panier['quantite'][$j];

                //$produit->setStock($produit->getStock() - $panier['quantite'][$i]);
                $produit->setStock($newStock);
                $this->manager->persist($produit);
                $this->manager->flush();

                $this->remove($panier['id_produit'][$j]);


            }
        }
        

    }




} 