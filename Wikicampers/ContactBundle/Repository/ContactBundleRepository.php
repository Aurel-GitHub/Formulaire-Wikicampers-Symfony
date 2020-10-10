<?php

namespace Aurel\ContactBundle\Repository;

use Aurel\ContactBundle\Entity\ContactBundle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method ContactBundle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactBundle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactBundle[]    findAll()
 * @method ContactBundle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactBundleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactBundle::class);
    }

    // /**
    //  * @return ContactBundle[] Returns an array of ContactBundle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactBundle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
