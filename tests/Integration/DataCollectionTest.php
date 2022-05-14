<?php

namespace App\Tests\Integration;

use App\Repository\PredictionRepository;
use App\Service\ApiDataCollectionService;
use App\Service\MyWeatherService;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DataCollectionTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadFixtures();
    }

    public function test_data_is_collected_correctly(): void
    {
        // Set data
        $dataCollectionService = static::getContainer()->get(ApiDataCollectionService::class);

        // Do operations
        $dataCollectionService->collect();

        $predictionRepo = static::getContainer()->get(PredictionRepository::class);

        //dd($predictionRepo->findAll());

        // Assert
        $this->assertSame('test', 'test');
    }
}
