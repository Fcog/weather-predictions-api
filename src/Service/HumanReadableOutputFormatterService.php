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
    public function output(
        array $predictionsData,
        string $selectedTempScale,
        string $city,
        \DateTimeInterface $date
    ): array
    {
        $output = [];

        $output['title'] = "Weather predictions in {$city} on {$date->format('F d, Y')}";

        $predictions = array_map( function($prediction) use ($selectedTempScale) {
            $temp = $this->tempScaleFactory->createFromCelsius($selectedTempScale, (int) $prediction['avg_temp']);

            return "At {$prediction['time']} is {$temp->getValue()} {$temp->getSymbol()}";
        }, $predictionsData);

        $output['predictions'] = $predictions;

        return $output;
    }
}
