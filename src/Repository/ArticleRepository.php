<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
      * @return Article[] Returns an array of Article objects
    */

    /*public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/

    public function findAllPublishedOrderByNewest()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id > 2')
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()

            ;
    }

    /**
     * @param string|null $term
     * @param string|null $l
     * @return QueryBuilder
     */
    public function getArticleWithSearchQueryBuilder(?string $term, $l): QueryBuilder
    {
        {
            $qb = $this->createQueryBuilder('a')
                ->innerJoin('a.author', 'u')
                ->addSelect('u');

            if ($term) {
                if ($l !== 'nl') {
                    $qb->andWhere('a.content LIKE :term OR a.title LIKE :term OR CONCAT(u.firstName, \' \', u.lastName) LIKE :term')
                        ->setParameter('term', "%" . $term . "%");
                } else {
                    $qb->andWhere('a.contentNl LIKE :term OR a.title LIKE :term OR CONCAT(u.firstName, \' \', u.lastName) LIKE :term')
                        ->setParameter('term', "%" . $term . "%");
                }
            }
            return $qb
                ->orderBy('a.createdAt', 'DESC');
            /*->getQuery()
            ->getResult();*/
        }
    }




    /*public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/

}
