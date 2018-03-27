<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class ExceptionMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'     => $this->collectNameArgumentWithPostfix($command, 'exception'),
            '--render' => $command->confirm('Add an empty render method?'),
            '--report' => $command->confirm('Add an empty report method?'),
        ];
    }
}