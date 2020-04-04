<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\ParameterBag;

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

    public function filter(ParameterBag $query)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.category', 'c')
                ->addSelect('c')
            ->leftJoin('a.classe', 'cls')
                ->addSelect('cls')
            ->leftJoin('a.subject', 'subj')
                ->addSelect('subj');

        $subject = $query->getInt('subject', -1);
        $classe = $query->getInt('classe', -1);
        $category = $query->getInt('category', -1);

        if ($subject) {
            $qb->andWhere('subj.id = :subject')
                ->setParameter('subject', $subject);
        }

        if ($classe) {
            $qb->andWhere('cls.id = :classe')
                ->setParameter('classe', $classe);
        }

        if ($category) {
            $qb->andWhere('c.id = :category')
                ->setParameter('category', $category);
        }

        return $qb->getQuery()->getResult();
    }
}
