<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $location = new Location();
        $location->setName('Amsterdam');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Rotterdam');
        $manager->persist($location);

        $manager->flush();
    }
}
