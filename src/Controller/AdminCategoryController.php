<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Cette route placée avant la class permet d'intégrer à chaque route de ce controller le terme /admin
 * on a défini dans security.yaml que toutes les routes commençant par /admin était accessible pour le ROLE_ADMIN
 * 
 * @Route("/admin")
 */

class AdminCategoryController extends AbstractController
{



    /**
     * La fonction ajouter_modifier_category() permet d'ajouter ou de modifier une catégorie en bdd
     * 
     * @Route("/gestion_category/ajouter", name="category_ajouter")
     * @Route("/gestion_category/modifier/{id}", name="category_modifier")
     *
     */
    public function ajouter_modifier_category(Category $category = null, Request $request, EntityManagerInterface $manager)
    {
        dd($request);
        if(!$category)
        {
            $category = new Category;
        }
        

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
           $modif = $category->getId() !== null;
           $manager->persist($category); 
           $manager->flush(); 

           $this->addFlash("success", ($modif) ? "La catégorie N°" . $category->getId() .  " a bien été modifiée" : "La catégorie a bien été ajoutée");

            return $this->redirectToRoute("category_afficher");

        }


        return $this->render("admin_category/category_ajouter_modifier.html.twig" , [
            "formCategory" => $form->createView(),
            "categorie" => $category,
            "modification" => $category->getId() !== null
        ]);
    }






     /**
      * La fonction afficher_category() permet d'afficher toutes les catégories sous forme de tableau (back office)
      *
      * @Route("/gestion_category/afficher", name="category_afficher")
      *
      */
      public function afficher_category(CategoryRepository $repoCategory, Request $request, EntityManagerInterface $manager)
      {

          $categories = $repoCategory->findAll();

          $category = new Category;

          $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
           $manager->persist($category); 
           $manager->flush(); 

           $this->addFlash("success",  "La catégorie a bien été ajoutée");

            return $this->redirectToRoute("category_afficher");

        }

          return $this->render("admin_category/category_afficher.html.twig" , [
              "categories" => $categories,
              "formCategory" => $form->createView(),
          ]);
      }





      /**
       * La fonction supprimer_category() permet de supprimer une catégorie existante
       * 
       * @Route("/gestion_category/supprimer/{id}", name="category_supprimer")
       */
      public function supprimer_category(Category $category, EntityManagerInterface $manager)
      {


        $nomCategory = $category->getNom();
        $idCategory = $category->getId();

        $manager->remove($category);
        $manager->flush();


        $this->addFlash('success', "La catégorie $nomCategory a bien été supprimée");

        return $this->redirectToRoute("category_afficher");
      }


    


}
