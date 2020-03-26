<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Repository;

use App\Entity\Classe;
use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Course::class);

        $this->paginator = $paginator;
    }

    public function paginate(Classe $class, int $page)
    {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.classes', 'cr')
                ->addSelect('cr')
            ->orderBy('c.addedAt', 'DESC')
            ->where('cr = :cls')
            ->setParameter('cls', $class);

        return $this->paginator->paginate(
            $query,
            $page,
            Course::NB_COURSES_PER_PAGE
        );
    }
}
