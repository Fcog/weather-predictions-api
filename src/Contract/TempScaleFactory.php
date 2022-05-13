<?php

namespace App\Contract;

use App\ObjectValue\TempScale;

interface TempScaleFactory
{
    public function create(string $selectedTempScale, TempScale $tempScale): TempScale;
}
