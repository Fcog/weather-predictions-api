<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Contract\PartnerInterface;
use App\Entity\Location;
use App\Entity\Prediction;
use App\Exception\PartnerApiDataFetchException;
use App\ObjectValue\Celsius;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataCollectionService implements DataCollection
{
    public function __construct(
        private PartnerRepository $partnerRepository,
        private EntityManagerInterface $entityManager,
        private HttpClientInterface $client
    )
    {
    }

    /**
     * @throws PartnerApiDataFetchException
     */
    public function collect()
    {
        $partners = $this->partnerRepository->getAll();

        foreach ($partners as $partner) {
            $encodedData = $this->fetchDataMock($partner);
            var_dump($encodedData);
            $decodedMetaData = $partner->decodeMetaData($encodedData);
            $decodedPredictionsData = $partner->decodePredictions($encodedData);

            $location = new Location();
            $location->setName('Amsterdam');
            $this->entityManager->persist($location);

            $prediction = new Prediction();
            $prediction->setLocation($location);
            $prediction->setPartnerId($partner->getId());
            $prediction->setDate(new \DateTime());
            $prediction->setTime('00:00');
            $prediction->setTemperature(Celsius::fromCelsius(10));
            $this->entityManager->persist($prediction);
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
