<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function searchCourses(?string $term): array
    {
        // Start building a query for the Course entity
        $qb = $this->createQueryBuilder('c');

        // If a search term is provided, match it against relevant fields (title, domain, description)
        if ($term) {
            $qb->andWhere('c.Title LIKE :term OR c.Domain LIKE :term OR c.Description LIKE :term')
               ->setParameter('term', '%' . $term . '%');
        }

        // You can add ORDER BY if desired, e.g.:
        // $qb->orderBy('c.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findByFilters(?string $searchTerm, ?string $domain, ?string $type): array
    {
        $qb = $this->createQueryBuilder('c');

        // 1) Text search (on Title, Description, Domain)
        if ($searchTerm) {
            $qb->andWhere('c.Title LIKE :search OR c.Description LIKE :search OR c.Domain LIKE :search')
            ->setParameter('search', '%' . $searchTerm . '%');
        }

        // 2) Domain filter
        // Only apply if $domain is not empty (and not "All")
        if ($domain) {
            $qb->andWhere('c.Domain = :domain')
            ->setParameter('domain', $domain);
        }

        // 3) Type filter
        if ($type) {
            $qb->andWhere('c.Type = :type')
            ->setParameter('type', $type);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Course[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
