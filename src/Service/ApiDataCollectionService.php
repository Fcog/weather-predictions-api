<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Entity\Location;
use App\Entity\Partner;
use App\Entity\Prediction;
use App\Exception\PartnerApiDataFetchException;
use App\ObjectValue\Celsius;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManager;
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
            $encodedData = $this->fetchData($partner);
            $decodedMetaData = $partner->decodeMetaData($encodedData);
            $decodedPredictionsData = $partner->decodePredictions($encodedData);

            $location = new Location();
            $location->setName('Amsterdam');

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
    public function fetchData(Partner $partner): array
    {
        try {
            $response = $this->client->request('GET', $partner->getApiUrl());

            return $response->toArray();
        } catch (\Throwable) {
            throw new PartnerApiDataFetchException();
        }
    }
}
