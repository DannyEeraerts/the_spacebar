<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Error403Controller extends AbstractController{

    /**
     * @Route ("/error403", name ="app_error403")
     */

    public function route_to_error403_page(Request $request)
    {
        return $this->render('exception/403.html.twig');
    }
}