<?php

namespace App\Command;

use App\Service\ApiDataCollectionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:collect-data',
    description: 'Fetches the API data from all Partners.',
    aliases: ['app:collect'],
    hidden: false
)]
class CollectData extends Command
{
    protected static $defaultName = 'app:collect-data';

    public function __construct(
        private ApiDataCollectionService $apiDataCollectionService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->apiDataCollectionService->collect();

            return Command::SUCCESS;
        } catch (\Throwable) {
            return Command::FAILURE;
        }
    }
}
