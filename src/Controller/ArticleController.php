<?php


namespace App\Controller;

use App\Service\MarkdownHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function show($slug, MarkdownHelper $markdownHelper)
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

        $articleIntro = <<<EOF
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
        $articleParagraph1 = <<<EOF
            <h4>Robotic Exploration</h4>
            <p>NASA's robotic spacecraft allow us *to visit comets, asteroids, and dwarf planets* up 
            close, and even bring back samples to study. We are **just beginning** to figure out what 
            these places are like, what they are made of, and how they formed.</p>
EOF;
        $articleParagraph2 = <<<EOF
            <h4>Raw Materials for Life?</h4>
            <p>Comets and asteroids probably delivered some of the water and other ingredients
                that allowed the complex chemistry of life to begin on Earth. The amino acid glycine
                was discovered in the comet dust returned to Earth by the Stardust mission. Glycine
                is used by living organisms to make proteins. The discovery supports the theory that
                some of life's ingredients formed in space and were delivered to Earth long ago by
                meteorite and comet impacts.</p>
            <p>Like forensic detectives, scientists follow clues about what happened when the
                solar system was young to piece together the story of our origins. What we learn will also
                teach us about systems of planets around other stars, and how life might develop there as
                well.</p>
EOF;

        $articleIntro = $markdownHelper->parse(
            $articleIntro
        );

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'articleIntro' => $articleIntro,
            'articleParagraph1' => $articleParagraph1,
            'articleParagraph2' => $articleParagraph2,
            'slug'=> $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_show_toggle", methods = {"POST"})
     */

    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted');
        return $this->json(['hearts' => rand(5, 100)]);
    }

}