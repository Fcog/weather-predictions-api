<?php

namespace App\ObjectValue;

use JetBrains\PhpStorm\Pure;

class Romer extends TempScale
{
    #[Pure]
    private function __construct(int $value)
    {
        parent::__construct($value, 'ºRo');
    }

    public function getCelsius(): int
    {
        return floor(($this->value / 0.525) - 7.50);
    }

    #[Pure]
    public static function fromCelsius(int $celsius): self
    {
        return new self(floor($celsius * 0.525 + 7.50));
    }
}
