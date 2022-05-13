<?php

namespace App\Tests\Integration;

use App\Service\MyWeatherService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DataCollectionTest extends KernelTestCase
{
    public function ptest_data_is_collected_correctly(): void
    {
        // Set data
        $dayNumber = 10;
        $date = new \DateTime();
        $date->modify("+{$dayNumber} day");

        $dataCollectionService = static::getContainer()->get(DataCollectionService::class);
        $weatherService = static::getContainer()->get(MyWeatherService::class);

        // Do operations
        $dataCollectionService->collect();
        $result = $weatherService->getWeather('Amsterdam', $date);

        // Assert
        $this->assertSame('test', $result);
    }
}
