<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrivacyPolicyController extends AbstractController
{
    /**
     * @Route("/privacyPolicy",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/privacyPolicy",
     *      name="app_privacy_policy",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     */
    public function showCookiePolicy(Request $request){
        return $this->render('policies/privacy_policy.html.twig');

    }
}