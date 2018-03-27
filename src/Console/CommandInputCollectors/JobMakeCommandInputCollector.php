<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class JobMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'   => $this->collectNameArgument($command, 'job'),
            '--sync' => $command->confirm('Is the job synchronous?'),
        ];
    }
}