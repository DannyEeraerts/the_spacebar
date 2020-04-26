<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslatorExampleController extends AbstractController
{
    /**
     * @Route("/translation/sample",
     *     defaults={"%locale%":"en"},
     *     )
     * @Route("/{_locale}/translation/sample",
     *     name="app_translation_sample",
     *     requirements={
     *         "_locale":"en|nl",
     *     }
     * )
     */

    public function translatationExample(TranslatorInterface $translator)
    {
        $translated = $translator->trans('I love Symfony');
        return new Response($translated);
    }

    /**
     * @Route("/translation/twigsample",
     *     defaults={"%locale%":"en"},
     *     )
     * @Route("/{_locale}/translation/twigsample",
     *     name="translation_twig_sample",
     *     requirements={
     *         "_locale":"en|nl",
     *     }
     * )
     */
    public function translationTwigSample() {
        return $this->render('translate/test.html.twig');
    }
}