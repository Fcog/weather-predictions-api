<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Contract\PartnerInterface;
use App\Dto\PartnerMetadata;
use App\Entity\Location;
use App\Entity\Prediction;
use App\Exception\NonExistentTempScaleException;
use App\Exception\PartnerApiDataFetchException;
use App\Exception\PartnerDataDecodeException;
use App\Repository\LocationRepository;
use App\Repository\PartnerRepository;
use App\Repository\PredictionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataCollectionService implements DataCollection
{
    public function __construct(
        private PartnerRepository $partnerRepository,
        private PredictionRepository $predictionRepository,
        private LocationRepository $locationRepository,
        private EntityManagerInterface $entityManager,
        private TempScaleFactoryService $tempScaleFactory,
        private HttpClientInterface $client
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

            $location = $this->setCity($decodedMetaData->getCity());

            foreach ($decodedPredictionsData as $predictionData) {
                $prediction = $this->setPrediction(
                    $predictionData,
                    $decodedMetaData,
                    $location,
                    $partner
                );

                $this->entityManager->persist($prediction);
            }

            $this->entityManager->flush();
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

    private function setCity(string $city): Location
    {
        $location = $this->locationRepository->findOneBy(['name' => $city]);

        if (empty($location)) {
            $location = new Location();
            $location->setName($city);
            $this->entityManager->persist($location);
        }

        return $location;
    }

    /**
     * @throws NonExistentTempScaleException
     */
    private function setPrediction(
        array $predictionData,
        PartnerMetadata $partnerMetadata,
        Location $location,
        PartnerInterface $partner
    ): Prediction
    {
        $prediction = $this->predictionRepository->findBy([
            'partner_id' => $partner->getId(),
            'time' => $predictionData['time'],
        ]);

        if (empty($prediction)) {
            $prediction = new Prediction();
            $prediction->setLocation($location);
            $prediction->setPartnerId($partner->getId());
            $prediction->setDate($partnerMetadata->getDate());
            $prediction->setTime($predictionData['time']);
        }

        $tempScale = $this->tempScaleFactory->create(
            $partnerMetadata->getTempScale(),
            (int) $predictionData['value']
        );
        $prediction->setTemperature($tempScale);

        return $prediction;
    }
}
