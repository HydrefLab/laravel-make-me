<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class ControllerMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options = [
            'name' => $this->collectNameArgumentWithPostfix($command, 'controller'),
        ];

        if ($command->confirm('Is this a resource controller?')) {
            $options = array_merge($options, [
                '--resource' => true,
                '--parent'   => $this->collectParentOption($command),
                '--model'    => $this->collectModelOption($command),
            ]);
        }

        return $options;
    }

    /**
     * @param Command $command
     * @return bool|string
     */
    private function collectParentOption(Command $command)
    {
        return $command->confirm('Is this a nested resource controller?')
            ? $this->collectNameArgument($command, 'parent model')
            : false;
    }

    /**
     * @param Command $command
     * @return bool|string
     */
    private function collectModelOption(Command $command)
    {
        return $command->confirm('Set route model binding?')
            ? $this->collectNameArgument($command, 'model')
            : false;
    }
}