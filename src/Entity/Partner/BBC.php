<?php

namespace App\Entity\Partner;

use App\Dto\PartnerMetadata;
use App\Dto\PredictionData;
use App\Enums\InputFormat;
use App\Exception\PartnerDataDecodeException;
use App\ObjectValue\TempScale;
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

    /**
     * @throws PartnerDataDecodeException
     */
    public function decodeMetaData(array $decodedData): PartnerMetadata
    {
        try {
            $decodedData = $decodedData['predictions'];

            $date = new \DateTimeImmutable();

            $metadata = new PartnerMetadata();
            $metadata->setDate($date->createFromFormat('Ymd', $decodedData['date']));
            $metadata->setCity($decodedData['city']);
            $metadata->setTempScale($decodedData['-scale']);

            return $metadata;
        } catch (\Throwable $throwable) {
            throw new PartnerDataDecodeException(
                'JSON schema not synced correctly: ' . $throwable->getMessage()
            );
        }
    }

    /**
     * @throws PartnerDataDecodeException
     * @returns array<int, PredictionData>
     */
    public function decodePredictions(array $decodedData): array
    {
        try {
            $data = [];
            $decodedData = $decodedData['predictions'];

            foreach ($decodedData['prediction'] as $prediction) {

                $predictionData = new PredictionData();
                $predictionData->setTime($prediction['time']);
                $predictionData->setTemp($prediction['value']);

                $data[] = $predictionData;
            }

            return $data;
        } catch (\Throwable $throwable) {
            throw new PartnerDataDecodeException(
                'JSON schema not synced correctly: ' . $throwable->getMessage()
            );
        }
    }
}
