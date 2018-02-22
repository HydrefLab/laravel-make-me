<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FactoryMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return $command->confirm('Make factory for model?')
            ? $this->collectFactoryAndModelOptions($command)
            : $this->collectFactoryOptions($command);
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectFactoryOptions(Command $command): array
    {
        $factory = $command->ask('Factory name');

        if (!Str::endsWith($factory, 'Factory')
            && $command->confirm("Append 'Factory' postfix to the factory name?")
        ) {
            $factory .= 'Factory';
        }

        return [
            'name' => $factory
        ];
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectFactoryAndModelOptions(Command $command): array
    {
        $model = $command->ask('Model name');

        return [
            'name' => $model . 'Factory',
            '-m' => $model
        ];
    }
}