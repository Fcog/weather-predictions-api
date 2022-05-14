<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Contract\PartnerInterface;
use App\Deserializer\LocationDeserializer;
use App\Deserializer\PredictionDeserializer;
use App\Exception\NonExistentTempScaleException;
use App\Exception\PartnerApiDataFetchException;
use App\Exception\PartnerDataDecodeException;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataCollectionService implements DataCollection
{
    public function __construct(
        private PartnerRepository $partnerRepository,
        private HttpClientInterface $client,
        private PredictionDeserializer $predictionDeserializer,
        private LocationDeserializer $locationDeserializer,
    )
    {
    }

    /**
     * @throws PartnerDataDecodeException
     * @throws NonExistentTempScaleException
     */
    public function collect()
    {
        $partners = $this->partnerRepository->getAll();

        foreach ($partners as $partner) {
            $encodedData = $this->fetchDataMock($partner);
            $decodedData = $partner->decode($encodedData);
            $decodedMetaData = $partner->decodeMetaData($decodedData);
            $decodedPredictionsData = $partner->decodePredictions($decodedData);

            $location = $this->locationDeserializer->deserialize($decodedMetaData->getCity());
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
    private function fetchData(PartnerInterface $partner): array
    {
        try {
            $response = $this->client->request('GET', $partner->getApiUrl());

            return $response->toArray();
        } catch (\Throwable) {
            throw new PartnerApiDataFetchException();
        }
    }

    private function fetchDataMock(PartnerInterface $partner): string
    {
        return file_get_contents(__DIR__ . '/../../tests/data/temps.' . $partner->getFormat()->value);
    }
}
