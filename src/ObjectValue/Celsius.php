<?php

namespace App\ObjectValue;

use JetBrains\PhpStorm\Pure;

class Celsius extends TempScale
{
    #[Pure]
    private function __construct(int $value)
    {
        parent::__construct($value, 'ºC');
    }

    public function getCelsius(): int
    {
        return $this->value;
    }

    public static function fromCelsius(int $celsius): self
    {
        return new self($celsius);
    }
}
