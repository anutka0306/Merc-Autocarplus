<?php

namespace App\Repository;

use App\Entity\ServiceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ManagerRegistry;
use UnexpectedValueException;

/**
 * @extends ServiceEntityRepository<ServiceCategory>
 */
class ServiceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceCategory::class);
    }

    public function findAllWithServices(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.services', 's')
            ->addSelect('s')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return ServiceCategory[] Returns an array of ServiceCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ServiceCategory
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
