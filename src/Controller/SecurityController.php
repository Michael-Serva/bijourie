<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
    /**
     * La fonction inscription() permet de s'inscrire sur le site
     * 
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder )
    {
        // UserPasswordEncoderInterface
        $user = new User;

        $form = $this->createForm(UserType::class, $user, array("inscription" => true) );


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            //dd($user);
            // $hash = $encoder->encodePassword($user, $user->getPassword());
            $hash = $encoder->hashPassword($user, $user->getPassword());

            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();


            $this->addFlash("success", $user->getPrenom() . ", votre inscription a bien été enregistrée");

            return $this->redirectToRoute("connexion");


        }

        
        return $this->render('security/inscription.html.twig', [
            "formUser" => $form->createView()
        ]);
    }


    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion()
    {
        return $this->render("security/connexion.html.twig");
    }


    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(){}

    
    /**
     * La fonction roles() permet de checker le rôle de l'utilisateur qui vient de se connecter 
     * et va permet la redirection sur une route en fonction de son rôle 
     * 
     * @Route("/roles", name="roles")
     */
    public function roles()
    {
        if($this->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute("dashboard");
        }
        elseif($this->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute("profil");
        }
    }

}




class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register()
    {

        $form = $this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label','Password'],
                'second_options' => ['label','Confirm Password']
            ])
            ->getForm();
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

