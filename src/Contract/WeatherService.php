<?php

namespace App\Contract;

use App\Exception\CityNotFoundException;
use App\Exception\InvalidDateException;

interface WeatherService
{
    /**
     * @throws CityNotFoundException
     * @throws InvalidDateException
     */
    public function getWeather(
        string $cityRequested,
        \DateTimeInterface $dateRequested,
        string $tempScaleRequested
    ): array;
}
