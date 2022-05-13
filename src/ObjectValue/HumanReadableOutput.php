<?php

namespace App\ObjectValue;

use App\Contract\OutputFormatter;
use App\Exception\NonExistentTempScaleException;
use App\Factory\TempScaleFactory;

class HumanReadableOutput implements OutputFormatter
{
    /**
     * @throws NonExistentTempScaleException
     */
    public function output(array $predictionsData, string $selectedTempScale): array
    {
        return array_map(function($prediction) use ($selectedTempScale) {
            $tempFactory = new TempScaleFactory();

            $temp = $tempFactory->create($selectedTempScale, $prediction->getTemperature());

            return "The weather in {$prediction->getLocation()->getName()} on {$prediction->getDate()?->format('F d, Y')} at {$prediction->getTime()} is {$temp->getValue()} {$temp->getSymbol()}";
        }, $predictionsData);
    }
}
