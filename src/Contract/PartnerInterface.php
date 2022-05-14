<?php

namespace App\Contract;

use App\Enums\InputFormat;

interface PartnerInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function getFormat(): ?InputFormat;

    public function getApiUrl(): ?string;

    public function decodeMetaData(string $encodedData): array;

    public function decodePredictions(string $encodedData): array;
}
