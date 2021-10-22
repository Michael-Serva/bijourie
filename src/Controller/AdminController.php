<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * En ajoutant cette annotation avant la class, toutes les routes se trouvant dedans héritent de /admin
 * dans security.yaml on a défini dans access_control que les routes commençant par /admin seront accéssible uniquement par ROLE_ADMIN 
 * 
 * @Route("/admin")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
