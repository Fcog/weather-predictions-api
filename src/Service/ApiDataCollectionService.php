<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Exception\PartnerApiDataFetchException;
use App\Repository\PartnerRepository;

class ApiDataCollectionService implements DataCollection
{
    public function __construct(
        private PartnerRepository $partnerRepository
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
            $encodedData = $partner->fetchData();
            $decodedMetaData = $partner->decodeMetaData($encodedData);
            $decodedPredictionsData = $partner->decodePredictions($encodedData);
        }
    }
}
