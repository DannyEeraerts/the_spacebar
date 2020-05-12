<?php


namespace App\Controller\Temporary;


use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentAdminController extends AbstractController
{
    /**
     * @Route("admin/comment/new")
     * @IsGranted("ROLE_ADMIN")
     */


    public function new(EntityManagerInterface $em){


        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find(5);

        $comment = new Comment();
        $comment->setAuthorName('Amy Oort')
            ->setContent(<<<EOF
Uranus, the seventh planet of the Solar System, has 27 known moons, most of which 
are named after characters that appear in, or are mentioned in, the works of William 
Shakespeare and Alexander Pope. Uranus's moons are divided into three groups: 
thirteen inner moons, five major moons, and nine irregular moons. The inner moons 
are small dark bodies that share common properties and origins with Uranus's rings. 
The five major moons are ellipsoidal, indicating that they reached hydrostatic equilibrium 
at some point in their past (and may still be in equilibrium), and four of them show signs 
of internally driven processes such as canyon formation and volcanism on their surfaces.
The largest of these five, Titania, is 1.578 km in diameter and the eighth-largest moon 
in the Solar System, about one-twentieth the mass of the Earth's Moon. The orbits of the 
regular moons are nearly coplanar with Uranus's equator, which is tilted 97.77° to its 
orbit. Uranus's irregular moons have elliptical and strongly inclined (mostly retrograde) 
orbits at large distances from the planet.
EOF
)
            ->setArticle($article);
        $em->persist($comment);
        $em->flush();

        return new Response(sprintf('Hiya! New article id: #%d author: %s',
            $comment->getId(),
            $comment->getAuthorName()
        ));
    }
}

