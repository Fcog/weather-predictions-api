<?php

namespace App\Tests\Integration;

use App\DataFixtures\LocationFixtures;
use App\DataFixtures\PredictionFixtures;
use App\Exception\InvalidDateException;
use App\Service\WeatherService;
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

    public function test_predictions_title(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = "Weather predictions in Amsterdam on {$today->format('F d, Y')}";

        // Do operations
        $weatherService = static::getContainer()->get(WeatherService::class);
        $result = $weatherService->getWeather('Amsterdam');

        // Assert
        $this->assertSame($expectedResult, $result['title']);
    }

    public function test_get_predictions_for_today(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = [
            "At 00:00 is 11 ºC",
            "At 01:00 is 12 ºC",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(WeatherService::class);
        $result = $weatherService->getWeather('Amsterdam');

        // Assert
        $this->assertSame($expectedResult, $result['predictions']);
    }

    public function test_get_predictions_for_today_in_fahrenheit(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = [
            "At 00:00 is 51 ºF",
            "At 01:00 is 53 ºF",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(WeatherService::class);
        $result = $weatherService->getWeather('Amsterdam', $today, 'fahrenheit');

        // Assert
        $this->assertSame($expectedResult, $result['predictions']);
    }

    public function test_get_predictions_for_today_in_romer(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = [
            "At 00:00 is 13 ºRo",
            "At 01:00 is 13 ºRo",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(WeatherService::class);
        $result = $weatherService->getWeather('Amsterdam', $today, 'romer');

        // Assert
        $this->assertSame($expectedResult, $result['predictions']);
    }

    public function test_get_predictions_for_day_10(): void
    {
        // Set data
        $dayNumber = 10;
        $date = new \DateTime();
        $date->modify("+{$dayNumber} day");

        $expectedResult = [
            "At 11:00 is 5 ºC",
            "At 12:00 is 3 ºC",
        ];

        // Do operations
        $weatherService = static::getContainer()->get(WeatherService::class);
        $result = $weatherService->getWeather('Amsterdam', $date);

        // Assert
        $this->assertSame($expectedResult, $result['predictions']);
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
        $weatherService = static::getContainer()->get(WeatherService::class);
        $weatherService->getWeather('Amsterdam', $date);
    }
}
