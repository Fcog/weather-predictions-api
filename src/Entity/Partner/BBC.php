<?php

namespace App\Entity\Partner;

use App\Entity\Partner;

class BBC extends Partner
{

    public function decodeMetaData(array $data): array
    {
        $encodedData = $this->fetchData();

        // TODO deserialize into Partner object
        $decodedData = [];

        return $decodedData;
    }

    public function decodePredictions(array $data): array
    {
        $encodedData = $this->fetchData();

        // TODO deserialize into Partner object
        $decodedData = [];

        return $decodedData;
    }
}
