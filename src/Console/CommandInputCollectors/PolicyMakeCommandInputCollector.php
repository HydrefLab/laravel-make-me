<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PolicyMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'    => $this->collectNameArgumentWithPostfix($command, 'policy'),
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
            ? Str::studly($command->ask('Model name related with the policy'))
            : false;
    }
}