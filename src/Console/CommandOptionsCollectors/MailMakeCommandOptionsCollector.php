<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;

class MailMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options = [
            'name' => $command->ask('Mail name'),
            '-f' => $command->confirm('Override existing mailable class?'),
        ];

        if ($command->confirm('Generate a new Markdown template for the mailable?')) {
            $options['-m'] = $command->ask('Template name');
        }

        return $options;
    }
}