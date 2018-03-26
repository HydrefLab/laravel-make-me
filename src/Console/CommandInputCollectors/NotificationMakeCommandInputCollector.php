<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class NotificationMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'       => $command->ask('Notification name'),
            '--markdown' => $this->collectMarkdownOption($command),
            '--force'    => $command->confirm('Override existing notification class?'),
        ];
    }

    /**
     * @param Command $command
     * @return bool|string
     */
    private function collectMarkdownOption(Command $command)
    {
        return $command->confirm('Generate a new Markdown template for the notification?')
            ? $command->ask('Template name')
            : false;
    }
}