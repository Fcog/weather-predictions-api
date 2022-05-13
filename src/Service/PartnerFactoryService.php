<?php

namespace App\Service;

use App\Contract\PartnerFactory;
use App\Entity\Partner;

class PartnerFactoryService implements PartnerFactory
{

    public function create(string $name, string $apiUrl, string $format): Partner
    {
        // TODO: Implement create() method.
    }
}
