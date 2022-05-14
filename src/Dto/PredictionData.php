<?php

namespace App\Dto;

class PredictionData
{
    public int $temp;
    public string $time;

    public function getTemp(): int
    {
        return $this->temp;
    }

    public function setTemp(string $temp): void
    {
        $this->temp = (int) $temp;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): void
    {
        $this->time = $time;
    }
}
