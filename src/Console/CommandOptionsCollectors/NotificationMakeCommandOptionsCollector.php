<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;

class NotificationMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options = [
            'name' => $command->ask('Notification name'),
            '-f' => $command->confirm('Override existing notification class?'),
        ];

        if ($command->confirm('Generate a new Markdown template for the notification?')) {
            $options['-m'] = $command->ask('Template name');
        }

        return $options;
    }
}