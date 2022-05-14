<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Contract\PartnerInterface;
use App\Entity\Location;
use App\Entity\Prediction;
use App\Exception\PartnerApiDataFetchException;
use App\Exception\PartnerDataDecodeException;
use App\Repository\PartnerRepository;
use App\Repository\PredictionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataCollectionService implements DataCollection
{
    public function __construct(
        private PartnerRepository $partnerRepository,
        private PredictionRepository $predictionRepository,
        private EntityManagerInterface $entityManager,
        private TempScaleFactoryService $tempScaleFactory,
        private HttpClientInterface $client
    )
    {
    }

    /**
     * @throws PartnerApiDataFetchException|PartnerDataDecodeException
     */
    public function collect()
    {
        $partners = $this->partnerRepository->getAll();

        foreach ($partners as $partner) {
            $encodedData = $this->fetchDataMock($partner);
            $decodedData = $partner->decode($encodedData);
            $decodedMetaData = $partner->decodeMetaData($decodedData);

            $decodedPredictionsData = $partner->decodePredictions($decodedData);

            $location = new Location();
            $location->setName($decodedMetaData->getCity());
            $this->entityManager->persist($location);

            foreach ($decodedPredictionsData as $predictionData) {
                $prediction = $this->predictionRepository->findBy([
                    'partner_id' => $partner->getId(),
                    'time' => $predictionData['time'],
                ]);

                if (empty($prediction)) {
                    $prediction = new Prediction();
                }

                $tempScale = $this->tempScaleFactory->create($decodedMetaData->getTempScale(), (int) $predictionData['value']);

                $prediction->setLocation($location);
                $prediction->setPartnerId($partner->getId());
                $prediction->setDate($decodedMetaData->getDate());
                $prediction->setTime($predictionData['time']);
                $prediction->setTemperature($tempScale);
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
}
