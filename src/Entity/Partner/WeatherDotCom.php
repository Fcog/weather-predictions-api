<?php

namespace App\Entity\Partner;

use App\Entity\Partner;
use App\Enums\InputFormat;
use JetBrains\PhpStorm\Pure;

class WeatherDotCom extends Partner
{
    #[Pure]
    public function __construct()
    {
        $this->id = 2;
        $this->name = 'weather.com';
        $this->api_url = 'https://weather.com/weather';
        $this->format = InputFormat::CSV;
    }

    public function decodeMetaData(array $encodedData): array
    {
        // TODO deserialize into Partner object
        $decodedData = [];

        return $decodedData;
    }

    public function decodePredictions(array $encodedData): array
    {
        // TODO deserialize into Partner object
        $decodedData = [];

        return $decodedData;
    }
}
