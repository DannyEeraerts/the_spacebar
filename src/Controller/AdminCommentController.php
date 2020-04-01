<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(CommentRepository $repository, Request $request)
    {
        $q = $request->query->get('q');
        $comments = $repository->findAllWithSearch($q);
        return $this->render('admin_comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}


