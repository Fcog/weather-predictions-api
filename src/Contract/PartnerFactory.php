<?php

namespace App\Contract;

use App\Entity\Partner;
use App\Enums\InputFormat;

interface PartnerFactory
{
    public function create(int $id, string $name, string $apiUrl, InputFormat $format): Partner;
}
