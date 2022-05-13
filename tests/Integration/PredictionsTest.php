<?php

namespace App\Tests\Integration;

use App\DataFixtures\LocationFixtures;
use App\DataFixtures\PartnerFixtures;
use App\DataFixtures\PredictionFixtures;
use App\Exception\InvalidDateException;
use App\Service\MyWeatherService;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PredictionsTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadFixtures([
            LocationFixtures::class,
            PredictionFixtures::class,
        ]);
    }

    public function test_get_predictions_for_today(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = [
            "The weather in Amsterdam on {$today->format('F d, Y')} at 00:00 is 10 ºC",
            "The weather in Amsterdam on {$today->format('F d, Y')} at 01:00 is 11 ºC",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(MyWeatherService::class);

        // Assert
        $this->assertSame($expectedResult, $weatherService->getWeather('Amsterdam'));
    }

    public function test_get_predictions_for_today_in_fahrenheit(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = [
            "The weather in Amsterdam on {$today->format('F d, Y')} at 00:00 is 50 ºF",
            "The weather in Amsterdam on {$today->format('F d, Y')} at 01:00 is 51 ºF",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(MyWeatherService::class);
        $result = $weatherService->getWeather('Amsterdam', $today, 'fahrenheit');

        // Assert
        $this->assertSame($expectedResult, $result);
    }

    public function test_get_predictions_for_today_in_romer(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = [
            "The weather in Amsterdam on {$today->format('F d, Y')} at 00:00 is 12 ºRo",
            "The weather in Amsterdam on {$today->format('F d, Y')} at 01:00 is 13 ºRo",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(MyWeatherService::class);
        $result = $weatherService->getWeather('Amsterdam', $today, 'romer');

        // Assert
        $this->assertSame($expectedResult, $result);
    }

    public function test_get_predictions_for_day_10(): void
    {
        // Set data
        $dayNumber = 10;
        $date = new \DateTime();
        $date->modify("+{$dayNumber} day");

        $expectedResult = [
            "The weather in Amsterdam on {$date->format('F d, Y')} at 11:00 is 5 ºC",
            "The weather in Amsterdam on {$date->format('F d, Y')} at 12:00 is 3 ºC",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(MyWeatherService::class);
        $result = $weatherService->getWeather('Amsterdam', $date);

        // Assert
        $this->assertSame($expectedResult, $result);
    }

    public function test_get_predictions_for_day_11(): void
    {
        // Assert exception
        $this->expectException(InvalidDateException::class);

        // Set data
        $dayNumber = 11;
        $date = new \DateTime();
        $date->modify("+{$dayNumber} day");

        // Do operations
        $weatherService = static::getContainer()->get(MyWeatherService::class);
        $weatherService->getWeather('Amsterdam', $date);
    }
}
