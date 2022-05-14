<?php

namespace App\Tests\Application;

use App\DataFixtures\LocationFixtures;
use App\DataFixtures\PredictionFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherEndpointDateTest extends WebTestCase
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

    public function test_get_predictions_for_day_10(): void
    {
        // Set data
        $dayNumber = 10;
        $dateRequested = new \DateTime();
        $dateRequested->modify("+{$dayNumber} day");

        $data = [
            "The weather in Amsterdam on {$dateRequested->format('F d, Y')} at 11:00 is 5 ºC",
            "The weather in Amsterdam on {$dateRequested->format('F d, Y')} at 12:00 is 3 ºC",
        ];

        $expectedResult = json_encode(['data' => $data]);

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

    public function test_get_predictions_for_yesterday(): void
    {
        // Set data
        $dayNumber = 1;
        $dateRequested = new \DateTime('yesterday');

        $expectedResult = '';

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam?date=' . $dateRequested->format('Y-m-d'));

        // Assert
        $this->assertResponseStatusCodeSame(204);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }
}
