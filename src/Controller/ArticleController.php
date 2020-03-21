<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug)
    {
        $comments = [
            'The Lyrids, which peak during late April, are one of the oldest known meteor showers: 
            Lyrids have been observed for 2,700 years. (The first recorded sighting of a Lyrid meteor 
            shower goes back to 687 BC by the Chinese.)',
            'The Eta Aquarids peak during early-May each year. Eta Aquarid meteors are known for their 
            speed. These meteors are fast—traveling at about 148,000 mph (66 km/s) into Earth\'s atmosphere.
             Fast meteors can leave glowing "trains" (incandescent bits of debris in the wake of the meteor)
              which last for several seconds to minutes. In general, 30 Eta Aquarid meteors can be seen 
              per hour during their peak.',
            'The Delta Aquariids are active beginning in mid-July and are visible until late-August. 
            These faint meteors are difficult to spot, and if there is a moon you will not be able to 
            view them. If the moon is not present, your best chance to see the Delta Aquariids is when 
            meteor rates rise during the shower\'s peak at the end of July.'];
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);
    }

}