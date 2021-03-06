<?php

namespace App\TempScale;

use JetBrains\PhpStorm\Pure;

class Romer extends TempScale
{
    #[Pure]
    public function __construct(int $value)
    {
        parent::__construct($value, 'romer','ºRo');
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
