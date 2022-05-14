<?php

namespace App\Repository;

use App\Entity\Partner;
use App\Entity\Partner\BBC;
use App\Entity\Partner\WeatherDotCom;
use JetBrains\PhpStorm\Pure;

class PartnerRepository
{
    private array $collection;

    #[Pure]
    public function __construct()
    {
        $this->collection = [
            new BBC(),
            //new WeatherDotCom(),
        ];
    }

    /**
     * @return array<int, Partner\PartnerBase>
     */
    public function getAll(): array
    {
        return $this->collection;
    }
}
