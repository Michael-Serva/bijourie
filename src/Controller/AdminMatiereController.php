<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 * @Route("/admin")
 */
class AdminMatiereController extends AbstractController
{
    /**
     * La fonction matiere_afficher() permet d'afficher sous forme de tableau la liste des matieres (BACK OFFICE)
     * On y trouvera le bouton pour ajouter un matiere
     * Chaque ligne du tableau on trouvera les liens de modifier et de supprimer 
     * 
     * @Route("/gestion_matiere/afficher", name="matiere_afficher")
     */
    public function matiere_afficher(MatiereRepository $repoMatiere)
    {
        return $this->render('admin_matiere/matiere_afficher.html.twig', [
            "matieres" => $repoMatiere->findAll()
        ]);
    }


    

    /**
     * la fonction matiere_ajouter() permet d'ajouter un matiere 
     * Cette route se trouve sur la route matiere_afficher
     * 
     * @Route("/gestion_matiere/ajouter", name="matiere_ajouter")
     * @Route("/gestion_matiere/modifier/{id}", name="matiere_modifier")
     */
    public function matiere_ajouter_modifier(Matiere $matiere = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$matiere)
        {
            $matiere = new Matiere;
        }
        

        $form = $this->createForm(MatiereType::class, $matiere);

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $modif = $matiere->getId() !== null;
            $manager->persist($matiere); 
            $manager->flush(); 

            $this->addFlash('success', ($modif) ? "La matière " . $matiere->getNom() ." a bien été modifiée" : "La matière " . $matiere->getNom() ." a bien été ajoutée");

            return $this->redirectToRoute("matiere_afficher");


        }
        

        return $this->render('admin_matiere/matiere_ajouter_modifier.html.twig', [
            "formMatiere" => $form->createView(), 
            "matiere" => $matiere,
            "modification" => $matiere->getId() !== null
        ]);
    }






    /**
     * @Route("/gestion_matiere/supprimer/{id}", name="matiere_supprimer")
     */
    public function matiere_supprimer(Matiere $matiere, EntityManagerInterface $manager)
    {



        $nomMatiere = $matiere->getNom();
        $idMatiere = $matiere->getId();

        $manager->remove($matiere);
        $manager->flush();


        $this->addFlash('success', "La matière $nomMatiere a bien été supprimée");

        return $this->redirectToRoute("matiere_afficher");


    }
}
