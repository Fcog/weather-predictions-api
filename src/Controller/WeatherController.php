<?php

namespace App\Controller;

use App\Contract\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/api/weather/{city}', name: 'app_weather', methods: ['GET'])]
    public function index(WeatherService $weatherService, string $city): Response
    {
        return $this->json($weatherService->getWeather($city));
    }
}
