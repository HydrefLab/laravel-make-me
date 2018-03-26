<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class ExceptionMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'     => $command->ask('Exception name'),
            '--render' => $command->confirm('Add an empty render method?'),
            '--report' => $command->confirm('Add an empty report method?'),
        ];
    }
}