<?php


namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Intl\Timezones;

class ArticleController extends AbstractController
{
/*@Route("/{locale}", name="app_homepage", locale="en", requirements = {"locale": "en|nl"})*/



    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {

        $articles = $repository->findAllPublishedOrderByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, /*MarkdownHelper $markdownHelper, */EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);
        if (!$article)
        {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        /*$comments = [
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
            meteor rates rise during the shower\'s peak at the end of July.'];*/

        /*$articleIntro = <<<EOF
At the very beginning of our solar system, **before** there was an Earth, Jupiter or
Pluto, a massive swirling cloud of dust and gas circled the young Sun. The dust 
particles in this disk collided with each other and formed into larger bits of rock. 
This process continued until they reached the size of boulders. Eventually this 
process of accretion formed the planets of our solar system.

Billions of small space rocks never evolved. Amazingly, many of these mysterious
worlds have been *altered very little* in the 4.6 billion years since they first 
formed. Their relatively pristine state makes the comets, asteroids and some meteors 
wonderful storytellers with much to share about what conditions were like in the 
early solar system. They can reveal secrets about our origins, chronicling the 
processes and events that led to *the birth of our world.* They might offer clues
about where the water and raw materials that made life possible on Earth came
from.
EOF;

        $articleIntro = $markdownHelper->parse(
            $articleIntro
        );*/

        return $this->render('article/show.html.twig', [
            'article' => $article,
           /* 'comments' => $comments,*/
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_show_toggle", methods = {"POST"})
     */

    /*public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted');
        return $this->json(['hearts' => rand(5, 100)]);
    }*/

    public function toggleArticleHeart(LoggerInterface $logger, Article $article, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }

}