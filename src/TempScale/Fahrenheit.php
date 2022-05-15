<?php

namespace App\TempScale;

use JetBrains\PhpStorm\Pure;

class Fahrenheit extends TempScale
{
    #[Pure]
    public function __construct(int $value)
    {
        parent::__construct($value, 'fahrenheit', 'ºF');
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
