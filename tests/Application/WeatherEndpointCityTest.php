<?php

namespace App\Tests\Application;

use App\DataFixtures\LocationFixtures;
use App\DataFixtures\PredictionFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherEndpointCityTest extends WebTestCase
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
        $data = [];

        $data['title'] = "Weather predictions in Amsterdam on {$today->format('F d, Y')}";

        $data['predictions'] = [
            "At 00:00 is 11 ºC",
            "At 01:00 is 12 ºC",
        ];

        $expectedResult = json_encode(['data' => $data]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam');
        $result = $this->client->getResponse()->getContent();

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_no_predictions_for_city_not_found(): void
    {
        // Set data
        $expectedResult = json_encode(['error' => 'City not found']);

        // Do operations
        $this->client->request('GET', '/api/weather/cali');

        // Assert
        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }
}
