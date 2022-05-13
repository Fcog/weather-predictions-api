<?php

namespace App\ObjectValue;

use JetBrains\PhpStorm\Pure;

class Fahrenheit extends TempScale
{
    #[Pure]
    private function __construct(int $value)
    {
        parent::__construct($value, 'ºF');
    }

    public function getCelsius(): int
    {
        return floor(($this->value - 32) * 5 / 9);
    }

    #[Pure]
    public static function fromCelsius(int $celsius): self
    {
        return new self(floor(($celsius * 9 / 5) + 32));
    }
}
