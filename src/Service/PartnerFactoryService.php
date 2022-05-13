<?php

namespace App\Service;

use App\Contract\PartnerFactory;
use App\Entity\Partner\BBC;
use App\Entity\Partner;
use App\Entity\Partner\WeatherDotCom;
use App\Enums\InputFormat;
use App\Exception\NonExistentPartnerException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PartnerFactoryService implements PartnerFactory
{

    public function __construct(
        private HttpClientInterface $client
    )
    {
    }

    /**
     * @throws NonExistentPartnerException
     */
    public function create(int $id, string $name, string $apiUrl, InputFormat $format): Partner
    {
        return match ($name) {
            'bbc' => new BBC($this->client, $id, $name, $apiUrl, $format),
            'weather.com' => new WeatherDotCom($this->client, $id, $name, $apiUrl, $format),
            default => throw new NonExistentPartnerException(),
        };
    }
}
