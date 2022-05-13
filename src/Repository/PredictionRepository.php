<?php

namespace App\Repository;

use App\Entity\Prediction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prediction>
 *
 * @method Prediction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prediction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prediction[]    findAll()
 * @method Prediction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PredictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prediction::class);
    }

    public function add(Prediction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Prediction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Prediction[] Returns an array of Prediction objects
     */
    public function findByCity(string $city, \DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.location', 'l')
            ->andWhere('l.name = :city')
            ->setParameter('city', $city)
            ->andWhere('p.date = :date')
            ->setParameter('date', $date)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
