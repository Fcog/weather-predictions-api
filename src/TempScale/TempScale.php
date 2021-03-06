<?php

namespace App\TempScale;

abstract class TempScale
{
    public function __construct(
        protected int $value,
        protected string $name,
        private string $symbol
    )
    {
    }

    abstract public function getCelsius(): int;

    abstract static public function fromCelsius(int $celsius): self;

    public function getValue(): int
    {
        return $this->value;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
