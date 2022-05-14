<?php

namespace App\Entity\Partner;

use App\Enums\InputFormat;
use JetBrains\PhpStorm\Pure;

class WeatherDotCom extends PartnerBase
{
    #[Pure]
    public function __construct()
    {
        parent::__construct(
            2,
            'weather',
            'https://weather.com/weather',
            InputFormat::CSV
        );
    }

    public function decodeMetaData(string $encodedData): array
    {
        // TODO deserialize into Partner object
        $decodedData = [];

        return $decodedData;
    }

    public function decodePredictions(string $encodedData): array
    {
        // TODO deserialize into Partner object
        $decodedData = [];

        return $decodedData;
    }
}
