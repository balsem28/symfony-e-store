<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByCategoryId($categoryId)
    {
        return $this->createQueryBuilder('p')
            ->join('p.categorie', 'c')
            ->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->getResult();
    }
    public function findLaptop()
    {
        return $this->createQueryBuilder('p')
            ->join('p.categorie', 'c')
            ->andWhere('c.name = :categoryName')
            ->setParameter('categoryName', 'laptop')
            ->getQuery()
            ->getResult();
    }
    public function findphone()
    {
        return $this->createQueryBuilder('p')
            ->join('p.categorie', 'c')
            ->andWhere('c.name = :categoryName')
            ->setParameter('categoryName', 'telephone et tablette')
            ->getQuery()
            ->getResult();
    }
    public function findelectro()
    {
        return $this->createQueryBuilder('p')
            ->join('p.categorie', 'c')
            ->andWhere('c.name = :categoryName')
            ->setParameter('categoryName', 'Electromenage')
            ->getQuery()
            ->getResult();
    }

    public function countAllProduit(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as produitCount') // Alias the count result
            ->getQuery()
            ->getSingleScalarResult();
    }

}
