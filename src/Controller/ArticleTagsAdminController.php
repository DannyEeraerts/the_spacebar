<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleTagsAdminController extends AbstractController
{

    /**
     * @Route("admin/article_tags/new")
     */

    public function new(EntityManagerInterface $em){

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find(4);

        /**
         * @var Tag[] $tag
         */

        $tags = [19,20];

        foreach ($tags as $tag) {
            $number = $this->getDoctrine()
                ->getRepository(Tag::class)
                ->find($tag);
            $article->addTag($number);
        }
        $em->flush();

        var_dump($article->getTags());

        return new Response('Hiya! New tags are added to article ');
    }
}
