<?php

namespace App\Controller;

use App\Contract\WeatherService;
use App\Exception\CityNotFoundException;
use App\Exception\InvalidDateException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/weather/{city}', name: 'app_weather', methods: ['GET'])]
    public function index(Request $request, WeatherService $weatherService, string $city): Response
    {
        $city = ucfirst($city);
        $date = $request->query->get('date');

        try {
            if ($date) {
                $date = new \DateTime($date);

                $data = $weatherService->getWeather($city, $date);
            } else {
                $data = $weatherService->getWeather($city);
            }

            return $this->json([
                'data' => $data,
            ]);
        } catch (CityNotFoundException | InvalidDateException $e) {
            return $this->json([], 204);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
