<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;

class PolicyMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options = [
            'name' => $command->ask('Policy name')
        ];

        if ($command->confirm('Is the policy related with the model?')) {
            $options['-m'] = $command->ask('Model name related with the policy');
        }

        return $options;
    }
}