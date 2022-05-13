<?php

namespace App\Tests\Application;

use App\DataFixtures\LocationFixtures;
use App\DataFixtures\PredictionFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherEndpointTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadFixtures([
            LocationFixtures::class,
            PredictionFixtures::class,
        ]);
    }

    public function test_get_predictions_for_city_found(): void
    {
        // Set data
        $today = new \DateTime();

        $expectedResult = json_encode([
            "The weather in Amsterdam on {$today->format('F d, Y')} at 00:00 is 10 ºC",
            "The weather in Amsterdam on {$today->format('F d, Y')} at 01:00 is 11 ºC",
        ]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam');

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }

    public function test_no_predictions_for_city_not_found(): void
    {
        // Set data
        $expectedResult = '';

        // Do operations
        $this->client->request('GET', '/api/weather/cali');

        // Assert
        $this->assertResponseStatusCodeSame(204);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }

    public function test_get_predictions_for_day_10(): void
    {
        // Set data
        $dayNumber = 10;
        $dateRequested = new \DateTime();
        $dateRequested->modify("+{$dayNumber} day");

        $expectedResult = json_encode([
            "The weather in Amsterdam on {$dateRequested->format('F d, Y')} at 11:00 is 5 ºC",
            "The weather in Amsterdam on {$dateRequested->format('F d, Y')} at 12:00 is 3 ºC",
        ]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam?date=' . $dateRequested->format('Y-m-d'));

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }

    public function test_get_predictions_for_day_11(): void
    {
        // Set data
        $dayNumber = 11;
        $dateRequested = new \DateTime();
        $dateRequested->modify("+{$dayNumber} day");

        $expectedResult = '';

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam?date=' . $dateRequested->format('Y-m-d'));

        // Assert
        $this->assertResponseStatusCodeSame(204);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }
}
