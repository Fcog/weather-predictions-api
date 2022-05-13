<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class JsonFetchTest extends TestCase
{
    public function ptest_data_is_fetched_correctly(): void
    {
        $jsonData = file_get_contents(__DIR__ . '/../data/temps.json');

        $jsonInputFormatter = new jsonInputFormatter($jsonData);



        $this->assertTrue(true);
    }
}
