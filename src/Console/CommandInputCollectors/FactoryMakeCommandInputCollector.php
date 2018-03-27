<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class FactoryMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

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
        return [
            'name' => $this->collectNameArgumentWithPostfix($command, 'factory'),
        ];
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectFactoryAndModelOptions(Command $command): array
    {
        $model = $this->collectNameArgument($command, 'model');

        return [
            'name'    => $model . 'Factory',
            '--model' => $model,
        ];
    }
}