<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CookiePolicyController extends AbstractController
{
    /**
     * @Route("/cookiePolicy",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/cookiePolicy",
     *      name="app_cookie_policy",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     */

    public function showCookiePolicy(){
        return $this->render('policies/cookie_policy.html.twig');
    }
}