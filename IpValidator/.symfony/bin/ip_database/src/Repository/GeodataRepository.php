<?php

namespace App\Repository;

use App\Entity\Geodata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Geodata|null find($id, $lockMode = null, $lockVersion = null)
 * @method Geodata|null findOneBy(array $criteria, array $orderBy = null)
 * @method Geodata[]    findAll()
 * @method Geodata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeodataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Geodata::class);
    }

    // /**
    //  * @return Geodata[] Returns an array of Geodata objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Geodata
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
