<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class AuthMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            '--views' => $command->confirm('Scaffold the authentication views?'),
            '--force' => $command->confirm('Overwrite existing views?'),
        ];
    }
}