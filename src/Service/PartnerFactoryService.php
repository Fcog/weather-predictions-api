<?php

namespace App\Service;

use App\Contract\PartnerFactory;
use App\Entity\Partner\BBC;
use App\Entity\Partner;
use App\Entity\Partner\WeatherDotCom;
use App\Exception\NonExistentPartnerException;

class PartnerFactoryService implements PartnerFactory
{

    /**
     * @throws NonExistentPartnerException
     */
    public function create(string $name, string $apiUrl, string $format): Partner
    {
        return match ($name) {
            'bbc' => new BBC(),
            'weather.com' => new WeatherDotCom(),
            default => throw new NonExistentPartnerException(),
        };
    }
}
