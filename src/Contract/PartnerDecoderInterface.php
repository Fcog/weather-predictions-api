<?php

namespace App\Contract;

use App\Dto\PartnerMetadata;
use App\Dto\PredictionData;
use App\Exception\PartnerDataDecodeException;

interface PartnerDecoderInterface
{
    /**
     * @throws PartnerDataDecodeException
     */
    public function decode(string $encodedData): array;

    /**
     * @throws PartnerDataDecodeException
     * @returns array<int, PartnerMetadata>
     */
    public function denormalizeMetaData(array $decodedData): PartnerMetadata;

    /**
     * @throws PartnerDataDecodeException
     * @returns array<int, PredictionData>
     */
    public function denormalizePredictions(array $decodedData): array;
}
