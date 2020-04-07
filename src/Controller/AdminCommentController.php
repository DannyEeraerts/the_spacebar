<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     * @IsGranted("ROLE_ADMIN_COMMENT")
     */
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        /*$comments = $repository->findAllWithSearch($q);*/
        $querybuilder = $repository->getWithSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $querybuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6); /*limit per page*/
        return $this->render('admin_comment/adminComment.html.twig', [
            /*'comments' => $comments,*/
            'pagination' => $pagination,
        ]);
    }
}


