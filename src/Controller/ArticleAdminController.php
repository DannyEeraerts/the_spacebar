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
        $article->setTitle("Knowledge of the Solar System")
            ->setSlug('Knowledge of the Solar System-'.rand(100,999))
            ->setContent(<<<EOF

<h4>Motions Within the Solar System</h4>
<p>The sun and planets each rotate on their axes. Because they formed from the same 
rotating disk, the planets, most of their satellites, and the asteroids, all revolve 
around the sun in the same direction as the sun rotates, and in nearly circular orbits.
The planets orbit the sun in or near the same plane, called the ecliptic (because 
it is where eclipses occur). Originally regarded as the ninth planet, Pluto always 
seemed a special case in that its orbit is highly inclined (by 17 degrees) and highly 
elliptical. Today we recognize it as a dwarf planet, as well as a member of the 
Kuiper Belt. Most planets rotate in or near the plane in which they orbit the sun, 
again because they formed, rotating, out of the same dust ring. The exception, 
Uranus, must have suffered a whopping collision that set it rotating on its side.</p>
<h4>Distances Within the Solar System</h4>
<p>The most commonly used unit of measurement for distances within the solar system is 
the astronomical unit (AU). The AU is based on the mean distance from the Sun to Earth, 
roughly 150,000,000 km. NASA's Deep Space Network refined the precise value of the AU 
in the 1960s by obtaining radar echoes from Venus. This measurement was important since 
spacecraft navigation depends on accurate knowledge of the au. Another way to indicate 
distances within the solar system is terms of light time, which is the distance light 
travels in a unit of time. Distances within the solar system, while vast compared to our 
travels on Earth's surface, are comparatively small-scale in astronomical terms. For 
reference, Proxima Centauri, the nearest star at about 4.2 light years away, is about 
265,000 AU from the Sun.</p>
<h4>Temperatures Within the Solar System</h4>
<p>The temperature of planets and other objects in the solar system is generally higher 
near the sun and colder as you move toward the outer reaches of the solar system. The 
temperature of low-density plasma (charged particles in the environment), though, is 
typically high, in the range of thousands of degrees (see "Our Bubble of Interplanetary 
Space" below).</p>
<p>Here is a table called the Solar System Temperature Reference. It shows examples and 
compares temperatures of objects and conditions from absolute zero through planet 
temperatures, to those of stars and beyond. Click the thumbnail to see the table. It also 
includes temperature conversion factors and links to a conversion engine.</p>
<table>
<tbody>
<tr>
<th>Kelvin</th>
<th>Degrees C<br/>(Celcius)</th>
<th>Degrees F<br/>(Fahrenheit)</th>
<th>Remarks</th>
</tr>
<tr>
<td>0</td>
<td>- 273.15</td>
<td>-459.67</td>
<td>Absolute Zero</td>
</tr>
<tr>
<td>72</td>
<td>-201</td>
<td>-330</td>
<td>Neptune</td>
</tr>
<tr>
<td>76</td>
<td>-197</td>
<td>-323</td>
<td>Uranus</td>
</tr>
<tr>
<td>100</td>
<td>-175</td>
<td>-280</td>
<td>Mercury Nighttime</td>
</tr>
<tr>
<td>134</td>
<td>-139</td>
<td>-219</td>
<td>Saturn</td>
</tr>
<tr>
<td>153</td>
<td>-120</td>
<td>-184</td>
<td>Mars Nighttime</td>
</tr>
<tr>
<td>165</td>
<td>-108</td>
<td>-163</td>
<td>Jupiter</td>
</tr>
<tr>
<td>273.15</td>
<td>0</td>
<td>32</td>
<td>Water ice melts</td>
</tr>
<tr>
<td>288</td>
<td>15</td>
<td>59</td>
<td>Mars Daytime</td>
</tr>
<tr>
<td>288.15</td>
<td>15</td>
<td>59</td>
<td>Standard room temperature</td>
</tr>
<tr>
<td>373.15</td>
<td>100</td>
<td>212</td>
<td>Liquid water boils</td>
</tr>
<tr>
<td>635</td>
<td>362</td>
<td>683</td>
<td>Venus</td>
</tr>
<tr>
<td>700</td>
<td>425</td>
<td>800</td>
<td>Mercury Daytime</td>
</tr>
<tr>
<td>750</td>
<td>475</td>
<td>890</td>
<td>Uranus</td>
</tr>
<tr>
</tr>
</tbody>
</table>
EOF);

            if (rand(1, 10) > 2){
                $article->setPublishedAt(new \DateTime(sprintf('%d days', rand(1, 100))));
            }
            $article->setAuthor('David Doody')
                ->setHeartCount(rand(5,100))
                ->setImageFileName('mishra_960.jpg');

            $em->persist($article);
            $em->flush();

        return new Response(sprintf('Hiya! New article id: #%d slug: %s',
        $article->getId(),
        $article->getSlug()
        ));
    }
}