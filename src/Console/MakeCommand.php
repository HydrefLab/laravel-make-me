<?php

namespace HydrefLab\Laravel\Make\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run interactive make command';

    /**
     * List of all make-like commands within Laravel.
     *
     * @var array
     */
    protected $illuminateCommands = [
        'auth',
        'command',
        'controller',
        'event',
        'exception',
        'factory',
        'job',
        'listener',
        'mail',
        'middleware',
        'migration',
        'model',
        'notification',
        'policy',
        'provider',
        'request',
        'resource',
        'rule',
        'seeder',
        'test',
    ];

    /**
     * Collection of all available commands for interactive make.
     *
     * @var Collection|null
     */
    protected $availableCommands;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->initAvailableCommands();

        if (true === $this->option('list')) {
            $this->displayAvailableCommands();

            return;
        }

        $this->info('Interactive Make!');
    }

    /**
     * Initialize list of available commands for interactive make.
     *
     * @return void
     */
    protected function initAvailableCommands()
    {
        $this->availableCommands = collect(array_keys($this->getApplication()->all()))
            ->filter(function (string $command) {
                return Str::startsWith($command, 'make:');
            })->map(function (string $command) {
                return str_replace('make:', '', $command);
            })->values();
    }

    /**
     * Display list of all available commands for interactive make.
     *
     * @return void
     */
    protected function displayAvailableCommands()
    {
        $commands = $this->availableCommands
            ->map(function (string $command) {
                return [$command];
            })->toArray();

        $this->table(['Commands'], $commands);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['list', null, InputOption::VALUE_NONE, 'List all available commands.'],
        ];
    }
}