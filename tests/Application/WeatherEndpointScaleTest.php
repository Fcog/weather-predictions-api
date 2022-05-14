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

    public function test_get_predictions_in_celsius(): void
    {
        // Set data
        $today = new \DateTime();

        $data['title'] = "Weather predictions in Amsterdam on {$today->format('F d, Y')}";

        $data['predictions'] = [
            "At 00:00 is 10 ºC",
            "At 01:00 is 11 ºC",
        ];

        $expectedResult = json_encode(['data' => $data]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam');
        $result = $this->client->getResponse()->getContent();

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_get_predictions_in_fahrenheit(): void
    {
        // Set data
        $today = new \DateTime();

        $data['title'] = "Weather predictions in Amsterdam on {$today->format('F d, Y')}";

        $data['predictions'] = [
            "At 00:00 is 50 ºF",
            "At 01:00 is 51 ºF",
        ];

        $expectedResult = json_encode(['data' => $data]);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam?scale=fahrenheit');

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }

    public function test_get_predictions_in_invalid_scale(): void
    {
        // Set data
        $expectedResult = json_encode(['error' => 'Invalid temperature scale']);

        // Do operations
        $this->client->request('GET', '/api/weather/amsterdam?scale=meters');

        // Assert
        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals($expectedResult, $this->client->getResponse()->getContent());
    }
}
