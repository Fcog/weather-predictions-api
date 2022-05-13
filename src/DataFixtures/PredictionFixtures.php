<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Prediction;
use App\ObjectValue\Celsius;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PredictionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $today = new \DateTime();
        $temp = Celsius::fromCelsius(10);
        $location = $manager->getRepository(Location::class)->findOneBy(['name' => 'Amsterdam']);

        $prediction = new Prediction();
        $prediction->setDate($today);
        $prediction->setTime('00:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $manager->persist($prediction);

        $temp = Celsius::fromCelsius(11);

        $prediction = new Prediction();
        $prediction->setDate($today);
        $prediction->setTime('01:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $manager->persist($prediction);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LocationFixtures::class,
        ];
    }
}
