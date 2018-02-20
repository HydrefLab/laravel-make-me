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
     * List of all make-like commands within Laravel framework.
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

        $command = $this->askWithCompletion('What would you like to make?', $this->availableCommands->toArray());

        true === $this->isIlluminateCommand($command)
            ? $this->handleIlluminateCommand($command)
            : $this->handleNonIlluminateCommand($command);
    }

    /**
     * Call Illuminate make-like command.
     *
     * @param string $command
     * @return void
     */
    protected function handleIlluminateCommand(string $command)
    {
        $this->call('make:' . $command, $this->getIlluminateCommandOptions($command));
    }

    /**
     * Call custom make-like command.
     *
     * @param string $command
     * @return void
     */
    protected function handleNonIlluminateCommand(string $command)
    {
        //
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
     * Check if given command is Illuminate command.
     *
     * @param string $command
     * @return bool
     */
    private function isIlluminateCommand(string $command): bool
    {
        return true === in_array($command, $this->illuminateCommands);
    }

    /**
     * Get arguments and options for Illuminate command.
     *
     * @param string $command
     * @return array
     */
    private function getIlluminateCommandOptions(string $command): array
    {
        $collectorClassName = $this->getIlluminateCommandOptionsCollectorClassName($command);

        if (true === class_exists($collectorClassName)) {
            return (new $collectorClassName())($this);
        }

        return [];
    }

    /**
     * Get Illuminate command arguments and options gatherer class name.
     *
     * @param string $command
     * @return string
     */
    private function getIlluminateCommandOptionsCollectorClassName(string $command): string
    {
        return "HydrefLab\\Laravel\\Make\\Console\\CommandOptionsCollectors\\" . ucfirst($command) . 'MakeCommandOptionsCollector';
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