<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class ListenerMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'     => $command->ask('Listener name'),
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
            ? $command->ask('Event class to listen for')
            : false;
    }
}