<?php

namespace App\Entity\Partner;

use App\Dto\PartnerMetadata;
use App\Enums\InputFormat;
use App\Exception\PartnerDataDecodeException;
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

    /**
     * @throws PartnerDataDecodeException
     */
    public function decode(string $encodedData): array
    {
        $decodedData = json_decode($encodedData, true);

        if ($decodedData === null) {
            throw new PartnerDataDecodeException('Bad JSON format');
        }

        return $decodedData;
    }

    public function decodeMetaData(array $decodedData): PartnerMetadata
    {
        // TODO deserialize into Partner object
        $decodedData = [];
        $metadata = new PartnerMetadata();

        return $metadata;
    }

    public function decodePredictions(array $decodedData): array
    {
        // TODO deserialize into Predictions object
        $decodedData = [];

        return $decodedData;
    }
}
