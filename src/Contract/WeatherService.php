<?php

namespace App\Contract;

use App\Exception\CityNotFoundException;

interface WeatherService
{
    /**
     * @throws CityNotFoundException
     */
    public function getWeather(
        string $city,
        \DateTimeInterface $date,
        string $selectedTempScale
    ): array;
}
