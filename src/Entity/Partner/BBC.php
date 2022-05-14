<?php

namespace App\Entity\Partner;

use App\Enums\InputFormat;
use JetBrains\PhpStorm\Pure;

class BBC extends PartnerBase
{
    #[Pure]
    public function __construct()
    {
        parent::__construct(
            1,
            'bbc',
            'https://bbc.com/weather',
            InputFormat::JSON
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
