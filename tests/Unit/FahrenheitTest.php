<?php

namespace App\Tests\Unit;

use App\ObjectValue\Fahrenheit;
use PHPUnit\Framework\TestCase;

class FahrenheitTest extends TestCase
{
    public function test_fahrenheit_to_celsius_convertion(): void
    {
        $fahrenheit = new Fahrenheit(32);

        $this->assertEquals(0, $fahrenheit->getCelsius());
    }

    public function test_fahrenheit_to_celsius_convertion_with_decimals_rounding_down(): void
    {
        $fahrenheit = new Fahrenheit(65);

        $this->assertEquals(18, $fahrenheit->getCelsius());
    }
}
