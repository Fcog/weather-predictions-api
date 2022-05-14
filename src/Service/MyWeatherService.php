<?php

namespace App\Service;

use App\Contract\OutputFormatter;
use App\Contract\WeatherService;
use App\Exception\CityNotFoundException;
use App\Exception\InvalidDateException;
use App\Exception\InvalidTempScaleException;
use App\Repository\LocationRepository;
use App\Repository\PredictionRepository;
use Doctrine\Persistence\ManagerRegistry;

class MyWeatherService implements WeatherService
{
    const MAX_DAYS = 10;

    public function __construct(
        private OutputFormatter $outputFormatter,
        private ManagerRegistry $managerRegistry,
    )
    {
    }

    /**
     * @throws CityNotFoundException
     * @throws InvalidDateException
     * @throws InvalidTempScaleException
     */
    public function getWeather(
        string $cityRequested,
        \DateTimeInterface $dateRequested = new \DateTime(),
        string $tempScaleRequested = 'celsius'
    ): array
    {
        $predictions = new PredictionRepository($this->managerRegistry);

        $this->validateCity($cityRequested);

        $this->validateDate($dateRequested);

        return $this->outputFormatter->output(
            $predictions->findByCity($cityRequested, $dateRequested),
            $tempScaleRequested
        );
    }

    /**
     * @throws CityNotFoundException
     */
    private function validateCity(string $city): void
    {
        $cities = new LocationRepository($this->managerRegistry);

        $isCityFound = $cities->findOneBy(['name' => $city]);

        if (!$isCityFound) {
            throw new CityNotFoundException();
        }
    }

    /**
     * @throws InvalidDateException
     */
    private function validateDate(\DateTimeInterface $dateRequested): void
    {
        $today = new \DateTime();
        $limitDate = new \DateTime();
        $limitDate->modify('+' . self::MAX_DAYS . ' day');

        $diff = $today->diff($dateRequested);
        $diffDays = (int) $diff->format( "%R%a" );

        $isDateUnderTheLimit = $diffDays < 0;
        $isDateOverTheLimit = $diffDays >= self::MAX_DAYS;

        if ($isDateUnderTheLimit || $isDateOverTheLimit) {
            throw new InvalidDateException();
        }
    }
}
