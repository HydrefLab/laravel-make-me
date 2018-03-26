<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class PolicyMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'    => $command->ask('Policy name'),
            '--model' => $this->collectModelOption($command),
        ];
    }

    /**
     * @param Command $command
     * @return bool|string
     */
    private function collectModelOption(Command $command)
    {
        return $command->confirm('Is the policy related with the model?')
            ? $command->ask('Model name related with the policy')
            : false;
    }
}