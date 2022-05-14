<?php

namespace App\Contract;

use App\Exception\CityNotFoundException;
use App\Exception\InvalidDateException;
use App\Exception\InvalidTempScaleException;

interface WeatherService
{
    /**
     * @throws CityNotFoundException
     * @throws InvalidDateException
     * @throws InvalidTempScaleException
     */
    public function getWeather(
        string $cityRequested,
        \DateTimeInterface $dateRequested,
        string $tempScaleRequested
    ): array;
}
