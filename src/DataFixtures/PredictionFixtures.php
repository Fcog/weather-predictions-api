<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Partner;
use App\Entity\Prediction;
use App\ObjectValue\Celsius;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PredictionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --------- Today's predictions ----------------

        $today = new \DateTime();
        $temp = Celsius::fromCelsius(10);

        $location = $manager->getRepository(Location::class)->findOneBy(['name' => 'Amsterdam']);
        $partner1 = $manager->getRepository(Partner::class)->findOneBy(['name' => 'BBC']);
        $partner2 = $manager->getRepository(Partner::class)->findOneBy(['name' => 'weather.com']);

        $prediction = new Prediction();
        $prediction->setDate($today);
        $prediction->setTime('00:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartner($partner1);
        $manager->persist($prediction);

        $temp = Celsius::fromCelsius(11);

        $prediction = new Prediction();
        $prediction->setDate($today);
        $prediction->setTime('01:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartner($partner2);
        $manager->persist($prediction);

        // --------- Upcoming predictions in day 10 ----------------

        $dayNumber = 10;
        $date = new \DateTime();
        $date = $date->modify("+{$dayNumber} day");

        $temp = Celsius::fromCelsius(5);

        $prediction = new Prediction();
        $prediction->setDate($date);
        $prediction->setTime('11:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartner($partner1);
        $manager->persist($prediction);

        $temp = Celsius::fromCelsius(3);

        $prediction = new Prediction();
        $prediction->setDate($date);
        $prediction->setTime('12:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartner($partner2);
        $manager->persist($prediction);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LocationFixtures::class,
            PartnerFixtures::class,
        ];
    }
}
