<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Partner;
use App\Entity\Prediction;
use App\Enums\InputFormat;
use App\ObjectValue\Celsius;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PredictionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --------- Partners ----------------

        $partner = new Partner\BBC();
        $partner->setId(1);
        $partner->setName('BBC');
        $partner->setApiUrl('https://bbc.com/weather');
        $partner->setFormat(InputFormat::JSON);

        $partner = new Partner\WeatherDotCom();
        $partner->setId(2);
        $partner->setName('weather.com');
        $partner->setApiUrl('https://weather.com/weather');
        $partner->setFormat(InputFormat::CSV);

        // --------- Today's predictions ----------------

        $today = new \DateTime();
        $temp = Celsius::fromCelsius(10);

        $location = $manager->getRepository(Location::class)->findOneBy(['name' => 'Amsterdam']);

        $prediction = new Prediction();
        $prediction->setDate($today);
        $prediction->setTime('00:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartnerId(1);
        $manager->persist($prediction);

        $temp = Celsius::fromCelsius(11);

        $prediction = new Prediction();
        $prediction->setDate($today);
        $prediction->setTime('01:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartnerId(2);
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
        $prediction->setPartnerId(1);
        $manager->persist($prediction);

        $temp = Celsius::fromCelsius(3);

        $prediction = new Prediction();
        $prediction->setDate($date);
        $prediction->setTime('12:00');
        $prediction->setTemperature($temp);
        $prediction->setLocation($location);
        $prediction->setPartnerId(2);
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
