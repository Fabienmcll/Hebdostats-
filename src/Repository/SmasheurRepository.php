<?php

namespace App\Repository;

use App\Entity\Smasheur;
use App\Entity\Tournoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @method Smasheur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Smasheur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Smasheur[]    findAll()
 * @method Smasheur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmasheurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Smasheur::class);
    }

     /**
      * @return Smasheur[] Returns an array of Smasheur objects
      */
    public function findByNbTournois(LoggerInterface $logger)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(Tournoi::class,'t')
            ->where('t.smasheur=s.id')
            ->groupBy('s.id')
            ->orderBy('count(t.id)', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Smasheur[] Returns an array of Smasheur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Smasheur
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
