<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class JobMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name' => $command->ask('Job name'),
            '--sync' => $command->confirm('Is the job synchronous?'),
        ];
    }
}