<?php


namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();
        $article->setTitle("The 9 best meteor showers to watch in 2020")
            ->setSlug('The-9-best-meteor-showers-to-watch-in-2020'.rand(100,999))
            ->setContent(<<<EOF
<h4>What is a meteor shower?</h4>
<p>Most meteors are tiny pieces of debris from the tail of comets. As comets 
circulate around the sun, they leave a long trail of cosmic debris, and every 
so often the Earth moves through that field.<p>
<p>Those tiny fragments enter the Earth’s atmosphere at blistering speeds, moving 
so rapidly that they heat up and illuminate the air around them — creating the 
thin streaks of light that we see, and admire, from our planet.</p>
<p>While most meteor showers originate from comets, some — like the Quadrantids, 
which peaked in early January, and the Geminids in December — are small fragments 
of asteroids.</p>
<h4>Meteor shower viewing tips</h4>
<ul>
<li>If you want to see a shooting star, experts say you should find a dark location — 
as far away as possible from bright city lights and street lights. Try going to a 
park or open field with a good view of the sky.</li>
<li>You don’t need any special equipment, like telescopes or binoculars. Astronomy 
experts say you just need your own set of eyes, but you should give them about 20 
minutes to adjust to the dark before looking for meteors shooting across the sky.</li>
<li>If you have a blanket or reclining lawn chair, you can lie down and look straight 
up into the night sky. Experts say it’s better to look at the entire sky, not just 
the origin point of the meteor shower.</li>
<li>If the moon is giving off a lot of light, either wait for it to dip lower in the 
sky or look as far away from the moonlight as possible.</li>
<li>Experts say the best time to look for meteor showers is generally from midnight to 
the pre-dawn hours. That’s when meteor showers tend to peak, producing the highest 
number of shooting stars per hour.</li>
</ul>
<h4>a quick look at the best meteor showers of the year</h4>
<ul>
<li>Lyrid meteor shower — Expected to peak April 21 to April 22.</li>
<li>Eta Aquariid meteor shower — Expected to peak May 4 to May 5.<li>
<li>Perseid meteor shower — Expected to peak Aug. 11 to Aug. 12.<li>
<li>Draconid meteor shower — Expected to peak Oct. 7 to Oct. 8.<li>
<li>Orionid meteor shower — Expected to peak Oct. 21 to Oct. 22.<li>
<li>Northern Taurid meteor shower — Expected to peak Nov. 11 to Nov. 12.<li>
<li>Leonid meteor shower — Expected to peak Nov. 16 to Nov. 17.<li>
<li>Geminid meteor shower — Expected to peak Dec. 13 to Dec. 14.<li>
<li>Ursid meteor shower — Expected to peak Dec. 22 to Dec. 23.<li>
</ul>
EOF);
            if (rand(1, 10) > 2){
                $article->setPublishedAt(new \DateTime(sprintf('%d days', rand(1, 100))));
            }

            $em->persist($article);
            $em->flush();

        return new Response(sprintf('Hiya! New article id: #%d slug: %s',
        $article->getId(),
        $article->getSlug()
        ));
    }
}