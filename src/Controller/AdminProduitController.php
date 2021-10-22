<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\DateFr;
use App\Form\ProduitType;
use App\Service\DateBart;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;

/**
 * En ajoutant cette annotation avant la class, toutes les routes se trouvant dedans héritent de /admin
 * dans security.yaml on a défini dans access_control que les routes commençant par /admin seront accéssible uniquement par ROLE_ADMIN 
 * 
 * @Route("/admin")
 */

class AdminProduitController extends AbstractController
{
    /*
        La class AdminProduitController contient les routes du CRUD du produit
        CRUD : CREATE (INSERT INTO) / READ (SELECT) / UPDATE / DELETE

        /gestion_produit/afficher     name="produit_afficher"
        /gestion_produit/ajouter      name="produit_ajouter"
        /gestion_produit/modifier     name="produit_modifier"
        /gestion_produit/supprimer    name="produit_supprimer"

    */




    /**
     * La fonction produit_afficher() permet d'afficher sous forme de tableau la liste des produits (BACK OFFICE)
     * On y trouvera le bouton pour ajouter un produit
     * Chaque ligne du tableau on trouvera les liens de modifier et de supprimer 
     * 
     * @Route("/gestion_produit/afficher", name="produit_afficher")
     */
    public function produit_afficher(ProduitRepository $repoProduit, DateFr $dateFr, DateBart $bart)
    {

        
        
        $produitsArray = $repoProduit->findAll();

        //dd($produitsArray);

        // $produitsArray = $dateFr->moisFr5($produitsArray);
        
        // choix des pays : de en es fr it pl pt tr
        // choix des heures, null H Hi His h
        $produitsArray = $bart->mois($produitsArray, "fr", "his");

        //dd($tab);



        return $this->render('admin_produit/produit_afficher.html.twig', [
            "produits" => $produitsArray
        ]);
    }


    

    /**
     * la fonction produit_ajouter() permet d'ajouter un produit 
     * Cette route se trouve sur la route produit_afficher
     * 
     * @Route("/gestion_produit/ajouter", name="produit_ajouter")
     */
    public function produit_ajouter(Request $request, EntityManagerInterface $manager)
    {
        // Pour ajouter un produit on a besoin de créer une nouvelle instance issu de la class Produit
        $produit = new Produit;
        dump($produit); // on observe qu'on retrouve toutes les propriétés à valeur  null

        // Pour créer un formulaire, on utilise la méthode createForm()
        // 2 arguments obligatoires :
        // 1e : class du formType
        // 2e : objet issu de la class

        // 3e facultatif : tableau 
        $form = $this->createForm(ProduitType::class, $produit,     array('ajouter' => true)    );
        // $form est un objet (qui contient des méthodes)

        $form->handleRequest($request); // traitement du formulaire



        // si le formulaire a été soumis (submit) et validé (constraintes/ sécurité)

        if($form->isSubmitted() && $form->isValid())
        {
            


            $imageFile = $form->get('image')->getData();

            //dump($request->request);
            //dd($imageFile);



            if($imageFile) // si $imageFile n'est pas vide (une image a été upload)
            {
                // 3 étapes pour le traitement de l'image


                // 1e : renommer l'image

                $nomReelImage = str_replace(" ", "-", $imageFile->getClientOriginalName());
                $nomImage = date("YmdHis") . "-" . uniqid() . "-" . $nomReelImage;
                // création d'une class pour le traitement de l'image
                // 20210622121848-60d1b9081f50d-montre5.jpg
                //dd($nomImage);


                // 2e : Envoyer l'image dans le dossier public / images / imagesUpload

                // move() permet de déplacer un fichier
                // 2 arguments :
                // 1e : le placement : getParameter()
                // 2e : le nom qu'aura le fichier 


                // getParameter() renvoit sur le fichier config/services.yaml 
                // Paramater à définir
                // reprendre le nom : associer le chemin 
                // %kernel.project_dir% c'est le projet
                // suivi du chemin : ex : public / images etc... 

                $imageFile->move(
                    $this->getParameter("image_produit"),
                    $nomImage
                );


                // 3e étape : envoyer $nomImage en bdd

                $produit->setImage($nomImage);


            }






            $produit->setDateAt(new \DateTime('now'));
           // dump($produit);

            $manager->persist($produit); // on persiste l'objet produit
            $manager->flush(); // on envoit l'objet produit en bdd



            //dd($produit);


            // Notification : "le produit a bien été ajouté"
            // addFlash() est une méthode permettant de véhiculer sur le navigateur une notification
            // 2 arguments :
            // 1e : le nom du flash 
            // 2e : le message

            $this->addFlash('success', "Le produit " . $produit->getTitre() ." a bien été ajouté");



            // Redirection
            // méthode redirectToRoute()
            // 2 arguments 
            // 1e OBLIGATOIRE : name de la route
            // 2e facultatif : c'est un tableau
            return $this->redirectToRoute("produit_afficher");


        }
        



        return $this->render('admin_produit/produit_ajouter.html.twig', [
            "formProduit" => $form->createView()
        ]);
    }



    /**
     * La fonction produit_modifier() permet de modifier un produit existant
     * Ajouter un paramètre id pour définir l'id du produit
     * 
     * @Route("/gestion_produit/modifier/{id}", name="produit_modifier")
     */
    public function produit_modifier(Produit $produit, Request $request, EntityManagerInterface $manager)
    {

        dump($produit);

        $form = $this->createForm(ProduitType::class, $produit,     array('modifier' => true)    );


        $form->handleRequest($request);// traitement du formulaire


        if($form->isSubmitted() && $form->isValid())
        {

            // if(empty($form->get('titre')))
            // {
            //     $form->get('titre')->addError(new FormError("Le titre ne peut pas être vides"));
            // }
            

            
           //dd($request);
            //dd($produit);


            $imageFile = $form->get('imageFile')->getData();


            if($imageFile) // si image upload
            {

                $nomImage = date('YmdHis') . "-" . uniqid() . "-" . $imageFile->getClientOriginalName() ;
                //dd(strlen($nomImage));


                $imageFile->move(
                    $this->getParameter('image_produit'),
                    $nomImage
                );

                //dump($produit->getImage());

                // unlink() permet de supprimer un fichier
                // 1 argument : chemin avec le nom du fichier 

                if($produit->getImage())
                {
                    unlink($this->getParameter('image_produit') . '/' . $produit->getImage());
                }
                


                $produit->setImage($nomImage);
                //dd($produit->getImage());


            }
            // image null => image null           OK
            // image null => upload image         OK
            // upload image => inchangé           OK
            // upload image => upload nouvelle image  (supp l'ancienne)   OK
            // upload image => image null (supp l'ancienne) 

            if($request->request->get('imageQuestion') == "oui")
            {
                unlink($this->getParameter('image_produit') . '/' . $produit->getImage());
                $produit->setImage(NULL);
            }


            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', "Le produit " . $produit->getTitre() ." a bien été modifié");

            return $this->redirectToRoute("produit_afficher");
            
        }



        return $this->render("admin_produit/produit_modifier.html.twig" , [
            "formProduit" => $form->createView(),
            "produit" => $produit
        ]);
    }





    /**
     * @Route("/gestion_produit/supprimer/image", name="supprimer_image_ajax")
     */
    public function supprimer_image_ajax(Request $request, ProduitRepository $repoProduit, EntityManagerInterface $manager)
    {
        $id = $request->request->get('id');
        dump($id);

        $produit = $repoProduit->find($id);

        
        unlink($this->getParameter('image_produit') . '/' . $produit->getImage());
        $produit->setImage(NULL);
            


        $manager->persist($produit);
        $manager->flush();

        $this->addFlash('success', "L'image du produit " . $produit->getTitre() ." a bien été supprimée");
        $data = 1;
        return new JsonResponse($data);


    }



    /**
     * @Route("/gestion_produit/image/supprimer/{id}", name="image_produit_supprimer")
     */
    public function image_produit_supprimer(Produit $produit, EntityManagerInterface $manager)
    {
        unlink($this->getParameter('image_produit') . '/' . $produit->getImage());
        $produit->setImage(NULL);

        $manager->persist($produit);
        $manager->flush();

        $this->addFlash('success', "L'image du produit " . $produit->getTitre() ." a bien été supprimée");

        return $this->redirectToRoute("produit_modifier" , ['id' => $produit->getId() ]);

    }




    /**
     * @Route("/gestion_produit/supprimer/{id}", name="produit_supprimer")
     */
    public function produit_supprimer(Produit $produit, EntityManagerInterface $manager)
    {

        if($produit->getImage())
        {
            unlink($this->getParameter('image_produit') . '/' . $produit->getImage());
        }

        $titreProduit = $produit->getTitre();
        $idProduit = $produit->getId();

        $manager->remove($produit);
        $manager->flush();


        $this->addFlash('success', "Le produit $titreProduit a bien été supprimé");

        return $this->redirectToRoute("produit_afficher");


    }








}// fermeture de la class (rien en dessous)
