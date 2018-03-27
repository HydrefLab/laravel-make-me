<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class TestMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'   => $this->collectNameArgumentWithPostfix($command, 'test'),
            '--unit' => $command->confirm('Is this a unit test?'),
        ];
    }
}