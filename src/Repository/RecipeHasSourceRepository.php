<?php

namespace App\Repository;

use App\Entity\RecipeHasSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeHasSource>
 *
 * @method RecipeHasSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeHasSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeHasSource[]    findAll()
 * @method RecipeHasSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeHasSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeHasSource::class);
    }

//    /**
//     * @return RecipeHasSource[] Returns an array of RecipeHasSource objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipeHasSource
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
