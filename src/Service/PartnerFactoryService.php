<?php

namespace App\Service;

use App\Contract\PartnerFactory;
use App\Entity\Partner\BBC;
use App\Entity\Partner;
use App\Entity\Partner\WeatherDotCom;
use App\Exception\NonExistentPartnerException;
use App\Repository\PartnerRepository;

class PartnerFactoryService implements PartnerFactory
{

    public function __construct(
        private PartnerRepository $partnerRepository
    )
    {
    }

    /**
     * @throws NonExistentPartnerException
     */
    public function create(string $name): Partner
    {
        $partner = match ($name) {
            'bbc' => new BBC(),
            'weather.com' => new WeatherDotCom(),
            default => throw new NonExistentPartnerException(),
        };

        $this->partnerRepository->add($partner);

        return $partner;
    }
}
