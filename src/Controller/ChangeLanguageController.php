<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChangeLanguageController extends AbstractController
{
    /**
     * @Route("/language",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/language",
     *      name="app_language",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     */

    function changeLocal(Request $request){
        $routeName = $request->attributes->get('_route');

        $routeParameters = $request->attributes->get('_route_params');

        // use this to get all the available attributes (not only routing ones):
        $allAttributes = $request->attributes->all();
        dump($routeName);
        dump($routeParameters);
        dump($allAttributes);
        die;
        return $this->render('security/register.html.twig');
    }

}
