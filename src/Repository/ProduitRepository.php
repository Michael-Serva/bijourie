<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findTout()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult()

        ;
    }


    public function findPrix($prix)
    {
        return $this->createQueryBuilder('p') // p est l'alias de la table produit
            ->andWhere('p.prix = :prix') // where avec un "marqueur" p.prix = le champ prix de la table produit
            ->setParameter('prix', $prix) // association le marqueur et sa valeur
            ->getQuery()
            ->getResult()

        ;
    }

    public function findOrder()
    {
        return $this->createQueryBuilder('p') // p est l'alias de la table produit
            ->orderBy("p.prix", "DESC")
            ->setMaxResults(3) // LIMIT
            ->getQuery()
            ->getResult()

        ;
    }

    public function findCategorie($categorie)
    {
        return $this->createQueryBuilder('p') 
            ->join('p.category', "c")
            ->andWhere('c.id IN(:cat)')
            ->setParameter("cat", $categorie)
            ->orderBy("c.nom", "ASC")
            ->getQuery()
            ->getResult()

        ;
    }

    public function findSearch($search)
    {
        return $this->createQueryBuilder('p') 
            ->join('p.category', "c")
            ->andWhere('p.titre LIKE :search')
            ->orWhere('p.prix LIKE :search')
            ->orWhere('c.nom LIKE :search')
            ->setParameter('search', "%{$search}%")
            ->getQuery()
            ->getResult()

        ;
    }



    public function findBetween($min, $max)
    {
        return $this->createQueryBuilder('p') 
            ->andWhere("p.prix BETWEEN :min AND :max")
            // ->andWhere("p.prix >= :min")
            // ->andWhere("p.prix <= :max")
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->orderBy("p.prix", "ASC")
            ->getQuery()
            ->getResult()

        ;
    }
}
