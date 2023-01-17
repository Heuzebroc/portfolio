<?php

namespace App\Repository;

use App\Entity\FormMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormMessage[]    findAll()
 * @method FormMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormMessage::class);
    }

    // /**
    //  * @return FormMessage[] Returns an array of FormMessage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormMessage
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
