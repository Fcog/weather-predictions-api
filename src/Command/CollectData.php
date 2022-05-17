<?php

namespace App\Command;

use App\Contract\DataCollection;
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
        private DataCollection $dataCollection,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->dataCollection->collect();

            $output->writeln('Data collected');

            return Command::SUCCESS;
        } catch (\Throwable) {
            $output->writeln('Error collecting data');
            return Command::FAILURE;
        }
    }
}
