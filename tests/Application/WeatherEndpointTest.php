<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherEndpointTest extends WebTestCase
{
    public function test_successful_city_found(): void
    {
        $response = static::createClient()->request('GET', '/api/weather/amsterdam');

        $this->assertResponseIsSuccessful();
    }
}
