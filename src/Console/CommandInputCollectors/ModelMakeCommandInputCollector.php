<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class ModelMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options = [
            'name'    => $command->ask('Model name'),
            '--pivot' => $command->confirm('Is the model a pivot model?'),
            '--force' => $command->confirm('Override existing model class?'),
        ];

        if ($command->confirm('Generate a migration, factory, and resource controller for the model?')) {
            return array_merge($options, [
                '--all' => true,
            ]);
        }

        $options = array_merge($options, [
            '--factory'    => $command->confirm('Generate a factory for the model?'),
            '--migration'  => $command->confirm('Generate a migration for the model?'),
            '--controller' => $command->confirm('Generate a controller for the model?'),
        ]);

        return array_merge($options, [
            '--resource' => $options['--controller'] ? $command->confirm('Is this a resource controller?') : false,
        ]);
    }
}