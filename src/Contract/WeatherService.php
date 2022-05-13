<?php

namespace App\Contract;

interface WeatherService
{
    public function getWeather(
        string $city,
        \DateTimeInterface $date,
        string $selectedTempScale
    ): array;
}
