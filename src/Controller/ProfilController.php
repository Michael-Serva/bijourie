<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * La fonction profil() permet d'afficher les informations personnelles de l'utilisateur Connecté
     * mais aussi proposer la possibilité de modifier le profil et le mot de passe 
     * 
     * @Route("", name="profil")
     */
    public function profil()
    {
        //$user = $this->getUser();
        //$userId = $this->getUser()->getId();
        //dd($user);
        return $this->render('profil/profil.html.twig');
    }




    /**
     * La fonction profil_modification() permet de modifier les informations personnelles de l'utilisateur Connecté
     * autrement dit dans la table user 
     * à l'exception du mot de passe
     * 
     * @Route("/modification/profil", name="profil_modification")
     */
    public function profil_modification(Request $request, EntityManagerInterface $manager)
    {

        $user = $this->getUser(); // l'objet du User Connecté
        //dump($user);
    
        
        $form = $this->createForm(UserType::class, $user, array("profil" => true) );

        //dd($user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            //dd($user);
            $manager->persist($user);
            $manager->flush();


            $this->addFlash("success", $user->getPrenom() . ", votre compte a bien été modifié");

            return $this->redirectToRoute("profil");


        }

        
        return $this->render('profil/profil_modification.html.twig', [
            "formUser" => $form->createView()
        ]);
    }


    /**
     * La fonction password_modification() permet de modifier le mot de passe de l'utilisateur Connecté
     * 
     * @Route("/modification/password", name="password_modification")
     */
    public function password_modification(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        $user = $this->getUser(); 

        $passwordUpdate = new PasswordUpdate;

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            // 1e étape : comparer oldPassword avec celui en BDD
            // 2e étape : vérifier que new et confirm soient identiques
            // =>> si on est dans la condition alors new et confirm sont identiques par les contraintes

            // si oldPassword ne correspond pas au password en BDD
            // la fonction prédéfinie password_verify() permet de comparer une string à un mdp hashé
            // il retourne un boolean
            // 2 arguments :
            // 1e: string
            // 2e: le mdp encodé

            
            //if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword() )) // false
            if(!$encoder->isPasswordValid($user, $passwordUpdate->getOldPassword()))
            {
                
                $form->get('oldPassword')->addError(new FormError("l'ancien mot de passe est incorrect"));
            }
            else // true
            {
                $hash = $encoder->hashPassword($user, $passwordUpdate->getNewPassword());

                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
    
    
                $this->addFlash("success", $user->getPrenom() . ", votre mot de passe a bien été modifié");
    
                return $this->redirectToRoute("profil");

            }
        }

        return $this->render('profil/password_modification.html.twig', [
            "formPassword" => $form->createView()
        ]);
    }

}
