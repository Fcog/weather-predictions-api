<?php

namespace App\Dto;

class PartnerMetadata
{
    public string $tempScale;
    public string $city;
    public \DateTimeImmutable $date;

    public function getTempScale(): string
    {
        return $this->tempScale;
    }

    public function setTempScale(string $tempScale): void
    {
        $this->tempScale = strtolower($tempScale);
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }
}
