<?php

namespace App\Service;

use App\Contract\DataCollection;
use App\Repository\PartnerRepository;

class ApiDataCollectionService implements DataCollection
{
    public function __construct(
        private PartnerRepository $partnerRepository
    )
    {
    }

    public function collect()
    {
        $partners = $this->partnerRepository->getAll();

        foreach ($partners as $partner) {
            $partner->getApiUrl();
        }
    }
}
