<?php


namespace App\Controller\Temporary;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagAdminController extends AbstractController
{
    /**
     * @Route("admin/tag/new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(EntityManagerInterface $em){
        $tag = new Tag();
        $slugText = "Galileo";
        $transform = str_replace(' ','-',$slugText) ;
        $tag->setName($slugText)
            ->setSlug($transform.'-'.rand(100,9999));
        $em->persist($tag);
        $em->flush();

        return new Response(sprintf('Hiya! New tag id: #%d slug: %s',
            $tag->getId(),
            $tag->getSlug()
        ));
    }
}