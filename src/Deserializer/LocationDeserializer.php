<?php

namespace App\Deserializer;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;

class LocationDeserializer
{
    public function __construct(
        private LocationRepository $locationRepository,
        private EntityManagerInterface $entityManager,
    )
    {
    }

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
