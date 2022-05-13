<?php

namespace App\Contract;

use App\Entity\Partner;

interface PartnerFactory
{
    public function create(string $name, string $apiUrl, string $format): Partner;
}
