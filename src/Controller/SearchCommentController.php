<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchCommentController extends AbstractController
{
    /**
     * @Route("/search/comment")
     *      defaults={"%locale%":"en"},
     *     )
     * @Route("/{_locale}/search/comment",
     *     name="search_comment",
     *     requirements={
     *         "_locale":"en|nl",
     *     }
     * )
     * @IsGranted("ROLE_USER")
     */


    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $q = htmlspecialchars($q);
        $querybuilder = $repository->getCommentWithSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $querybuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6); /*limit per page*/
        return $this->render('search/searchComment.html.twig', [
            /*'comments' => $comments,*/
            'pagination' => $pagination,
        ]);
    }
}


