<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ListenerMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'     => $this->collectNameArgumentWithPostfix($command, 'listener'),
            '--queued' => $command->confirm('Should event listener be queued?'),
            '--event'  => $this->collectEventOption($command),
        ];
    }

    /**
     * @param Command $command
     * @return bool|string
     */
    private function collectEventOption(Command $command)
    {
        return $command->confirm('Do you want to listen for a particular event?')
            ? Str::studly($command->ask('Event class to listen for'))
            : false;
    }
}