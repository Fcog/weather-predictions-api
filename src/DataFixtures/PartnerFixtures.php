<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use App\Enums\InputFormat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PartnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $partner = new Partner();
        $partner->setName('BBC');
        $partner->setApiUrl('https://bbc.com/weather');
        $partner->setFormat(InputFormat::JSON);
        $manager->persist($partner);

        $partner = new Partner();
        $partner->setName('weather.com');
        $partner->setApiUrl('https://weather.com/weather');
        $partner->setFormat(InputFormat::CSV);
        $manager->persist($partner);

        $manager->flush();
    }
}
