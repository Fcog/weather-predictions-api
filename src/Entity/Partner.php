<?php

namespace App\Entity;

use App\Enums\InputFormat;
use App\Exception\PartnerApiDataFetchException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class Partner
{
    public function __construct(
        private HttpClientInterface $client,
        private int $id,
        private string $name,
        private string $api_url,
        private InputFormat $format
    )
    {
    }

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

    /**
     * @throws PartnerApiDataFetchException
     */
    public function fetchData(): array
    {
        try {
            $response = $this->client->request('GET', $this->getApiUrl());

            return $response->toArray();
        } catch (\Throwable) {
            throw new PartnerApiDataFetchException();
        }
    }

    public abstract function decodeMetaData(array $data): array;

    public abstract function decodePredictions(array $data): array;
}
