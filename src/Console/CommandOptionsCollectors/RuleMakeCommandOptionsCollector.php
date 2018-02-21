<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;

class RuleMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name' => $command->ask('Rule name')
        ];
    }
}