<?php

namespace App\Service;

use App\Exception\InvalidTempScaleException;
use App\TempScale\Celsius;
use App\TempScale\Fahrenheit;
use App\TempScale\Romer;
use App\TempScale\TempScale;

class TempScaleFactoryService
{
    /**
     * @throws InvalidTempScaleException
     */
    public function convert(string $selectedTempScale, TempScale $tempScale): TempScale
    {
        return match ($selectedTempScale) {
            'fahrenheit' => Fahrenheit::fromCelsius($tempScale->getCelsius()),
            'celsius' => Celsius::fromCelsius($tempScale->getCelsius()),
            'romer' => Romer::fromCelsius($tempScale->getCelsius()),
            default => throw new InvalidTempScaleException(),
        };
    }

    /**
     * @throws InvalidTempScaleException
     */
    public function create(string $selectedTempScale, int $temp): TempScale
    {
        return match ($selectedTempScale) {
            'fahrenheit' => new Fahrenheit($temp),
            'celsius' => new Celsius($temp),
            'romer' => new Romer($temp),
            default => throw new InvalidTempScaleException(),
        };
    }

    /**
     * @throws InvalidTempScaleException
     */
    public function createFromCelsius(string $selectedTempScale, int $celsius): TempScale
    {
        return match ($selectedTempScale) {
            'fahrenheit' => Fahrenheit::fromCelsius($celsius),
            'celsius' => Celsius::fromCelsius($celsius),
            'romer' => Romer::fromCelsius($celsius),
            default => throw new InvalidTempScaleException(),
        };
    }
}
