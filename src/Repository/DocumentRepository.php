<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function filter(ParameterBag $query)
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.category', 'c')
                ->addSelect('c')
            ->leftJoin('d.classe', 'cls')
                ->addSelect('cls')
            ->leftJoin('d.subject', 'subj')
                ->addSelect('subj')
            ->andWhere('d.enabled = true');

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
