<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\SpaService;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Translatable\TranslatableListener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\SpaServiceRepositoryInterface;

/**
 * @extends ServiceEntityRepository<SpaService>
 *
 * @method SpaService|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpaService|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpaService[]    findAll()
 * @method SpaService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineSpaServiceRepository extends ServiceEntityRepository implements SpaServiceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpaService::class);
    }

    public function getAllServicesWithLocale(string $locale = 'es'): array
    {
        $queryBuilder = $this->createQueryBuilder("p");
    
        $query = $queryBuilder->getQuery();
    
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
    
        $query->setHint(TranslatableListener::HINT_TRANSLATABLE_LOCALE, $locale);
    
        return $query->getResult();
    }


    public function save(SpaService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SpaService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SpaService[] Returns an array of SpaService objects
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

//    public function findOneBySomeField($value): ?SpaService
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
