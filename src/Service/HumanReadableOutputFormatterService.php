<?php

namespace App\Service;

use App\Contract\OutputFormatter;
use App\Exception\InvalidTempScaleException;

class HumanReadableOutputFormatterService implements OutputFormatter
{
    public function __construct(
        private TempScaleFactoryService $tempScaleFactory
    )
    {
    }

    /**
     * @throws InvalidTempScaleException
     */
    public function output(array $predictionsData, string $selectedTempScale): array
    {
        return array_map( function($prediction) use ($selectedTempScale) {
            $temp = $this->tempScaleFactory->convert($selectedTempScale, $prediction->getTemperature());

            return "The weather in {$prediction->getLocation()->getName()} on {$prediction->getDate()?->format('F d, Y')} at {$prediction->getTime()} is {$temp->getValue()} {$temp->getSymbol()}";
        }, $predictionsData);
    }
}
