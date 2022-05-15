<?php

namespace App\Deserializer;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * If Symfony's deserializer is used this Class won't be needed.
 */
class LocationDeserializer
{
    public function __construct(
        private LocationRepository $locationRepository,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * TODO Use the serializer component
     */
    public function deserialize(string $city): Location
    {
        $location = $this->locationRepository->findOneBy(['name' => $city]);

        if (empty($location)) {
            $location = new Location();
            $location->setName($city);
            $this->entityManager->persist($location);
        }

        return $location;
    }
}
