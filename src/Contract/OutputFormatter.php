<?php

namespace App\Contract;

use App\Entity\Prediction;
use App\Exception\InvalidTempScaleException;

interface OutputFormatter
{
    /**
     * @param array<Prediction> $predictionsData
     * @throws InvalidTempScaleException
     */
    public function output(
        array $predictionsData,
        string $selectedTempScale,
        string $city,
        \DateTimeInterface $date
    ): array;
}
