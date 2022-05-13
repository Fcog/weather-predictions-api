<?php

namespace App\Controller;

use App\Contract\WeatherService;
use App\Exception\CityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/weather/{city}', name: 'app_weather', methods: ['GET'])]
    public function index(WeatherService $weatherService, string $city): Response
    {
        $city = ucfirst($city);

        try {
            return $this->json($weatherService->getWeather($city));
        } catch (CityNotFoundException $e) {
            return $this->json([], 204);
        }
    }
}
