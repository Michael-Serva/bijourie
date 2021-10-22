<?php

namespace App\Controller;
// App = src

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController // héritage AbstractController
{
    // une route est "une page web : inscription.php etc.."
    // un controller peut contenir plusieurs routes
    
    
    /**
     * ici : commentaires, en équipe, on peut définir quelle est cette route, l'intérêt 
     * lorsque la ligne commence par un @ il s'agit d'une annotation suivi d'une majuscule
     * 
     * 
     * @Route("/page", name="pageName")
     * pas de simple quote dans les annotations uniquement des doubles
     * 1e argument : c'est la route (url : localhost:8000/page)
     * 2e argument : c'est le nom de la route 
     */
    public function page(): Response
    {

        $prenom = "bart";

        
        return $this->render('page/index.html.twig', [
            "prenom" => $prenom,
            "ageTwig" => 20
            // key => $value
            // la key (sans dollar) est la variable qu'on passe en twig
            // la $value provient du controller
        ]);

        //render() permet de relier la fonction à sa vue
        // 1e argument (obligatoire) : le fichier html.twig
        // 2e argument (facultatif) : c'est un tableau
    }



    // annotation route
    // route /contact
    // name contact

    // funciton contact

    // render page/contact.html.twig 

    // twig heritage de la base html twig





    

    /**
     * 
     * @Route("/contact", name="contactName" )
     */
    public function contactFunction() 
    {




        return $this->render("page/contact.html.twig");
    }


    /**
     * 
     * la route qui est vide (ou juste /) renvoit sur la page principale du site
     * 
     * @Route("/", name="accueil" )
     */
    public function accueil() 
    {


        return $this->render("page/accueil.html.twig");
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function change_locale($locale, Request $request)
    {
        //dd($request);
            $request->getSession()->set('_locale', $locale);
        return $this->redirect($request->headers->get('referer'));
    }




}
