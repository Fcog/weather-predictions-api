<?php

namespace App\Entity;

use App\Enums\InputFormat;

abstract class Partner
{
    protected int $id;
    protected string $name;
    protected string $api_url;
    protected InputFormat $format;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getApiUrl(): ?string
    {
        return $this->api_url;
    }

    public function setApiUrl(string $api_url): self
    {
        $this->api_url = $api_url;

        return $this;
    }

    public function getFormat(): ?InputFormat
    {
        return $this->format;
    }

    public function setFormat(InputFormat $format): self
    {
        $this->format = $format;

        return $this;
    }

    public abstract function decodeMetaData(array $encodedData): array;

    public abstract function decodePredictions(array $encodedData): array;
}
