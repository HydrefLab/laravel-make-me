<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;

class ProviderMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name' => $command->ask('Provider name')
        ];
    }
}