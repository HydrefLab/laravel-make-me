<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;

class ControllerMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options['name'] = $command->ask('Controller name');

        if ($command->confirm('Is this a resource controller?')) {
            $options['-r'] = true;

            if ($command->confirm('Is this a nested resource controller?')) {
                $options['-p'] = $command->ask('Parent model name');
            }

            if ($command->confirm('Set route model binding?')) {
                $options['-m'] = $command->ask('Model name');
            }
        }

        return $options;
    }
}