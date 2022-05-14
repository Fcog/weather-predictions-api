<?php

namespace App\Service;

use App\Exception\NonExistentTempScaleException;
use App\ObjectValue\Celsius;
use App\ObjectValue\Fahrenheit;
use App\ObjectValue\Romer;
use App\ObjectValue\TempScale;

class TempScaleFactoryService
{
    /**
     * @throws NonExistentTempScaleException
     */
    public function convert(string $selectedTempScale, TempScale $tempScale): TempScale
    {
        return match ($selectedTempScale) {
            'fahrenheit' => Fahrenheit::fromCelsius($tempScale->getCelsius()),
            'celsius' => Celsius::fromCelsius($tempScale->getCelsius()),
            'romer' => Romer::fromCelsius($tempScale->getCelsius()),
            default => throw new NonExistentTempScaleException(),
        };
    }

    /**
     * @throws NonExistentTempScaleException
     */
    public function create(string $selectedTempScale, int $temp): TempScale
    {
        return match ($selectedTempScale) {
            'fahrenheit' => new Fahrenheit($temp),
            'celsius' => new Celsius($temp),
            'romer' => new Romer($temp),
            default => throw new NonExistentTempScaleException(),
        };
    }
}
