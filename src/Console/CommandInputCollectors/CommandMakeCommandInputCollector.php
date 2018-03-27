<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class CommandMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'      => $this->collectNameArgumentWithPostfix($command, 'command'),
            '--command' => $command->ask('Command name use in the terminal', 'command:name'),
        ];
    }
}