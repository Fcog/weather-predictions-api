<?php

namespace App\Tests\Application;

use App\DataFixtures\LocationFixtures;
use App\DataFixtures\PredictionFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherEndpointScaleTest extends WebTestCase
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

    public function test_get_predictions_for_celsius(): void
    {
        // Set data
        $today = new \DateTime();

        $data = [
            "The weather in Amsterdam on {$today->format('F d, Y')} at 00:00 is 10 ºC",
            "The weather in Amsterdam on {$today->format('F d, Y')} at 01:00 is 11 ºC",
        ];

        $expectedResult = json_encode(['data' => $data]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam');

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }

    public function test_get_predictions_for_fahrenheit(): void
    {
        // Set data
        $today = new \DateTime();

        $data = [
            "The weather in Amsterdam on {$today->format('F d, Y')} at 00:00 is 50 ºF",
            "The weather in Amsterdam on {$today->format('F d, Y')} at 01:00 is 51 ºF",
        ];

        $expectedResult = json_encode(['data' => $data]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam?scale=fahrenheit');

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }
}
