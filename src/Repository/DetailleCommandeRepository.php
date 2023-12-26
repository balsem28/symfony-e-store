<?php

namespace App\Repository;

use App\Entity\DetailleCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailleCommande>
 *
 * @method DetailleCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailleCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailleCommande[]    findAll()
 * @method DetailleCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailleCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailleCommande::class);
    }

//    /**
//     * @return DetailleCommande[] Returns an array of DetailleCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetailleCommande
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

        public function findByCommandeId($commandeId)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.commande = :commandeId')
            ->setParameter('commandeId', $commandeId)
            ->getQuery()
            ->getResult();
    }

}

