<?php

namespace App\Entity\Partner;

use App\Contract\PartnerInterface;
use App\Enums\InputFormat;

abstract class PartnerBase implements PartnerInterface
{
    public function __construct(
        protected int $id,
        protected string $name,
        protected string $apiUrl,
        protected InputFormat $format
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getApiUrl(): ?string
    {
        return $this->apiUrl;
    }

    public function getFormat(): ?InputFormat
    {
        return $this->format;
    }
}
