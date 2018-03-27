<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ResourceMakeCommandInputCollector
{
    use CollectNameArgumentTrait;

    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return $command->confirm('Is this a resource collection?')
            ? $this->collectResourceCollectionOptions($command)
            : $this->collectResourceOptions($command);
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectResourceOptions(Command $command): array
    {
        return [
            'name' => $this->collectNameArgumentWithPostfix($command, 'resource'),
        ];
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectResourceCollectionOptions(Command $command): array
    {
        $resource = $this->collectNameArgument($command, 'resource');

        if (!Str::endsWith($resource, 'Collection')
            && $command->confirm("Append 'Collection' postfix to the resource name?")
        ) {
            $resource .= 'Collection';
        }

        return [
            'name'         => $resource,
            '--collection' => true,
        ];
    }
}