<?php

namespace App\Contract;

use App\Exception\InvalidTempScaleException;
use App\Exception\PartnerApiDataFetchException;
use App\Exception\PartnerDataDecodeException;
use App\Partner\PartnerBase;

interface DataCollection
{
    /**
     * @throws PartnerDataDecodeException
     * @throws InvalidTempScaleException
     * @throws PartnerApiDataFetchException
     */
    public function collect(): void;
}
