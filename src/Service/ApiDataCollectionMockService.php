<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Deserializer\LocationDeserializer;
use App\Deserializer\PredictionDeserializer;
use App\Exception\InvalidTempScaleException;
use App\Exception\PartnerDataDecodeException;
use App\Partner\PartnerBase;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When(env: 'dev')]
class ApiDataCollectionMockService implements DataCollection
{
    /**
     * @param iterable<PartnerBase> $partners
     */
    public function __construct(
        private PredictionDeserializer $predictionDeserializer,
        private LocationDeserializer $locationDeserializer,
        private iterable $partners
    )
    {
    }

    /**
     * @throws PartnerDataDecodeException
     * @throws InvalidTempScaleException
     */
    public function collect(): void
    {
        foreach ($this->partners as $partner) {
            $encodedData = $this->fetchData($partner);
            $decodedData = $partner->decode($encodedData);
            $decodedMetaData = $partner->denormalizeMetaData($decodedData);
            $decodedPredictionsData = $partner->denormalizePredictions($decodedData);

            $location = $this->locationDeserializer->deserialize(
                $decodedMetaData->getCity()
            );

            $this->predictionDeserializer->deserialize(
                $decodedPredictionsData,
                $decodedMetaData,
                $location,
                $partner
            );
        }
    }

    private function fetchData(PartnerBase $partner): string
    {
        return file_get_contents(__DIR__ . '/../../tests/data/temps.' . $partner->getFormat()->value);
    }
}
