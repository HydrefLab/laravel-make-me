<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

trait CollectNameArgumentTrait
{
    /**
     * @param Command $command
     * @param string $resourceType
     * @return string
     */
    private function collectNameArgument(Command $command, string $resourceType): string
    {
        $resourceType = ucfirst($resourceType);
        $name = ucfirst($command->ask("$resourceType name"));

        return $this->shouldAddPostfix($command, $name, $resourceType)
            ? $name . $resourceType
            : $name;
    }

    /**
     * @param Command $command
     * @param string $name
     * @param string $resourceType
     * @return bool
     */
    private function shouldAddPostfix(Command $command, string $name, string $resourceType): bool
    {
        $question = sprintf("Append '%s' postfix to the %s name?", $resourceType, mb_strtolower($resourceType));

        return !Str::endsWith(mb_strtolower($name), mb_strtolower($resourceType))
            && $command->confirm($question, true);
    }
}