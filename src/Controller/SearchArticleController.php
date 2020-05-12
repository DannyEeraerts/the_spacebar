<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchArticleController extends AbstractController
{
    /**
     * @Route("/search/article")
     *      defaults={"%locale%":"en"},
     *     )
     * @Route("/{_locale}/search/article",
     *     name="search_article",
     *     requirements={
     *         "_locale":"en|nl",
     *     }
     * )
     * @IsGranted("ROLE_USER")
     */

    public function search(ArticleRepository $repository, Request $request, PaginatorInterface $paginator){
        $q = $request->query->get('q');
        $l = $request->getLocale();
        $q = ltrim(htmlspecialchars($q));
        $querybuilder = $repository->getArticleWithSearchQueryBuilder($q,$l);
        $pagination = $paginator->paginate(
            $querybuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6); /*limit per page*/

        return $this->render('search/searchArticle.html.twig', [
            'pagination' => $pagination,
        ]);
    }

}