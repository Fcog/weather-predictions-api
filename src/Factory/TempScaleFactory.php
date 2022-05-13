<?php

namespace App\Factory;

use App\Exception\NonExistentTempScaleException;
use App\ObjectValue\Celsius;
use App\ObjectValue\Fahrenheit;
use App\ObjectValue\Romer;
use App\ObjectValue\TempScale;

class TempScaleFactory
{
    /**
     * @throws NonExistentTempScaleException
     */
    public function create(string $selectedTempScale, TempScale $tempScale): TempScale
    {
        return match ($selectedTempScale) {
            'fahrenheit' => Fahrenheit::fromCelsius($tempScale->getCelsius()),
            'celsius' => Celsius::fromCelsius($tempScale->getCelsius()),
            'romer' => Romer::fromCelsius($tempScale->getCelsius()),
            default => throw new NonExistentTempScaleException(),
        };
    }
}
