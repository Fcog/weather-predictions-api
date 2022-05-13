<?php

namespace App\Contract;

use App\Entity\Partner;

interface PartnerDecoder
{
    public function decodeMetaData(): void;

    public function decodePredictions(): void;
}
