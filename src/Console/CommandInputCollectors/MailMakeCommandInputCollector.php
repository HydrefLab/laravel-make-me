<?php

namespace HydrefLab\Laravel\Make\Console\CommandInputCollectors;

use Illuminate\Console\Command;

class MailMakeCommandInputCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        return [
            'name'       => $command->ask('Mail name'),
            '--markdown' => $this->collectMarkdownOption($command),
            '--force'    => $command->confirm('Override existing mailable class?'),
        ];
    }

    /**
     * @param Command $command
     * @return bool|string
     */
    private function collectMarkdownOption(Command $command)
    {
        return $command->confirm('Generate a new Markdown template for the mailable?')
            ? $command->ask('Template name')
            : false;
    }
}