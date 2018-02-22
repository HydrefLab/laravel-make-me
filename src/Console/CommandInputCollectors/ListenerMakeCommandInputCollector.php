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
        $options = [
            'name' => $command->ask('Listener name'),
            '--queued' => $command->confirm('Should event listener be queued?'),
        ];

        if ($command->confirm('Do you want to listen for a particular event?')) {
            $options['-e'] = $command->ask('Event class to listen for');
        }

        return $options;
    }
}