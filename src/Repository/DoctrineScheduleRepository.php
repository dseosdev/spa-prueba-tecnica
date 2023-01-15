<?php

namespace App\Repository;

use DateTime;
use App\Entity\Schedule;
use App\Entity\SpaService;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\ScheduleRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Schedule>
 *
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineScheduleRepository extends ServiceEntityRepository implements ScheduleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    public function save(Schedule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Schedule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSchedulesByDate(DateTime $day, SpaService $spaService): ?array
    {
        return $this->createQueryBuilder('s')
           ->andWhere('s.day = :day')
           ->andWhere('s.spaService = :spaService')
           ->setParameter('day', $day)
           ->setParameter('spaService', $spaService)
           ->getQuery()
           ->getResult()
       ;
    }

}
