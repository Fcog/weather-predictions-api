<?php

namespace App\Controller;

use App\Exception\CityNotFoundException;
use App\Exception\InvalidDateException;
use App\Exception\InvalidTempScaleException;
use App\Service\WeatherService;
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
        $date = $request->query->get('date', '');
        $scale = $request->query->get('scale', 'celsius');

        try {

            $date = new \DateTime($date);

            $data = $weatherService->getWeather($city, $date, $scale);

            return $this->json([
                'data' => $data,
            ]);
        }
        catch (CityNotFoundException) {
            return $this->json([
                'error' => 'City not found'
            ], 400);
        }
        catch (InvalidDateException) {
            return $this->json([
                'error' => 'Invalid date'
            ], 400);
        }
        catch (InvalidTempScaleException) {
            return $this->json([
                'error' => 'Invalid temperature scale'
            ], 400);
        }
        catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
