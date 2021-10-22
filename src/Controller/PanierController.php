<?php

namespace App\Controller;

use App\Service\Panier;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{



    /**
     * @Route("/panier", name="panier")
     */
    public function panier(SessionInterface $session, Panier $panier)
    {

        $panierPerso = $session->get('panier');
        //$session->remove("panier");


        

        dump($panierPerso);
        $total = 0;
        if($panierPerso != null)
        {
            $panierPerso = $panier->verification();
            $total = $panier->montantTotal();
        }
        

        return $this->render('panier/panier.html.twig', [
            "panier" => $panierPerso,
            "total" => $total
        ]);
    }


    /**
     * @Route("/panier/add", name="panier_add")
     */
    public function panier_add(Request $request, ProduitRepository $repoProduit, Panier $panier)
    {

        //dd($request);
        
        $quantite = $request->request->get('quantite');
        $id_produit = $request->request->get('id');
        

        $produit = $repoProduit->find($id_produit);

        //dd($produit);

        $panier->add($produit->getTitre(), $id_produit, $quantite, $produit->getPrix());

        return $this->redirectToRoute("panier");

    }


    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function panier_remove($id, Panier $panier)
    {
        $panier->remove($id);

        return $this->redirectToRoute("panier");
    }


    /**
     * @Route("/panier/vider", name="panier_vider")
     */
    public function panier_vider(Panier $panier)
    {
        $panier->vider();

        return $this->redirectToRoute("panier");
    }


    /**
     * @Route("/panier/payer", name="panier_payer")
     */
    public function panier_payer(Panier $panier)
    {
        $user = $this->getUser();

        $panier->payer($user);

        return $this->redirectToRoute("panier");
    }












}
