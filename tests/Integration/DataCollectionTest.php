<?php

namespace App\Tests\Integration;

use App\Repository\PredictionRepository;
use App\Service\ApiDataCollectionService;
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
        $predictionRepo = static::getContainer()->get(PredictionRepository::class);

        // Do operations
        $dataCollectionService->collect();
        $predictions = $predictionRepo->findAll();

        // Assert
        $this->assertSame('00:00', $predictions[0]->getTime());
        $this->assertSame(31, $predictions[0]->getTemperature()->getValue());
        $this->assertSame('02:00', $predictions[2]->getTime());
        $this->assertSame(25, $predictions[2]->getTemperature()->getValue());
    }
}
