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
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
                'SELECT avg(p.temperature) as avg_temp, p.time
                FROM App\Entity\Prediction p
                JOIN p.location l
                WHERE l.name = :city AND p.date = :date
                GROUP BY p.partner_id, p.time'
            )
            ->setParameter('city', $city)
            ->setParameter('date', $date);

        return $query->getResult();
    }
}
