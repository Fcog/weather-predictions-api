<?php

namespace App\Service;

use App\Contract\OutputFormatter;
use App\Contract\WeatherService;
use App\Exception\CityNotFoundException;
use App\Repository\LocationRepository;
use App\Repository\PredictionRepository;
use Doctrine\Persistence\ManagerRegistry;

class MyWeatherService implements WeatherService
{
    public function __construct(
        private OutputFormatter $outputFormatter,
        private ManagerRegistry $managerRegistry
    )
    {
    }

    /**
     * @throws CityNotFoundException
     */
    public function getWeather(
        string $city,
        \DateTimeInterface $date = new \DateTime(),
        string $selectedTempScale = 'celsius'
    ): array
    {
        $predictions = new PredictionRepository($this->managerRegistry);
        $cities = new LocationRepository($this->managerRegistry);

        $cityFound = $cities->findOneBy(['name' => $city]);

        if (!$cityFound) {
            throw new CityNotFoundException();
        }

        return $this->outputFormatter->output(
            $predictions->findByCity($city),
            $selectedTempScale
        );
    }
}
