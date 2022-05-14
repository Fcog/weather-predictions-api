<?php

namespace App\Entity\Partner;

use App\Entity\Partner;
use App\Enums\InputFormat;
use JetBrains\PhpStorm\Pure;

class BBC extends Partner
{
    #[Pure]
    public function __construct()
    {
        $this->id = 1;
        $this->name = 'bbc';
        $this->api_url = 'https://bbc.com/weather';
        $this->format = InputFormat::JSON;
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
