<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class ProviderMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name' => $this->collectNameArgumentWithPostfix($command, 'provider'),
        ];
    }
}