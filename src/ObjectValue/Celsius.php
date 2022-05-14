<?php

namespace App\ObjectValue;

use JetBrains\PhpStorm\Pure;

class Celsius extends TempScale
{
    #[Pure]
    public function __construct(int $value)
    {
        parent::__construct($value, 'celsius','ºC');
    }

    public function getCelsius(): int
    {
        return $this->value;
    }

    #[Pure]
    public static function fromCelsius(int $celsius): self
    {
        return new self($celsius);
    }
}
