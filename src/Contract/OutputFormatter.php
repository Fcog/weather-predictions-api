<?php

namespace App\Contract;

use App\Entity\Prediction;

interface OutputFormatter
{
    /**
     * @param array<Prediction> $predictionsData
     */
    public function output(
        array $predictionsData,
        string $selectedTempScale
    ): array;
}
