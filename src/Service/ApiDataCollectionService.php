<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Deserializer\LocationDeserializer;
use App\Deserializer\PredictionDeserializer;
use App\Partner\PartnerBase;
use App\Exception\InvalidTempScaleException;
use App\Exception\PartnerApiDataFetchException;
use App\Exception\PartnerDataDecodeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataCollectionService implements DataCollection
{
    /**
     * @param iterable<PartnerBase> $partners
     */
    public function __construct(
        private HttpClientInterface $client,
        private PredictionDeserializer $predictionDeserializer,
        private LocationDeserializer $locationDeserializer,
        private iterable $partners
    )
    {
    }

    /**
     * @throws PartnerDataDecodeException
     * @throws InvalidTempScaleException
     * @throws PartnerApiDataFetchException
     */
    public function collect(): void
    {
        foreach ($this->partners as $partner) {
            // TODO fetch data for the upcoming 10 days
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

    /**
     * @throws PartnerApiDataFetchException
     */
    private function fetchData(PartnerBase $partner): string
    {
        try {
            $response = $this->client->request('GET', $partner->getApiUrl());

            return $response->getContent();
        } catch (\Throwable) {
            throw new PartnerApiDataFetchException();
        }
    }
}
