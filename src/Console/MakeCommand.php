<?php

namespace HydrefLab\Laravel\Make\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
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

        $this->isIlluminateCommand($command)
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
        $this->call('make:' . $command, $this->collectIlluminateCommandInput($command));
    }

    /**
     * Call custom make-like command.
     *
     * @param string $command
     * @return void
     */
    protected function handleNonIlluminateCommand(string $command)
    {
        $command = 'make:' . $command;
        $commandInstance = $this->getApplication()->find($command);

        $options = $commandInstance->collectInputForInteractiveMake();

        $commandInstance->run(
            $this->createInputFromArguments(Arr::add($options, 'command', $command)), $this->output
        );
    }

    /**
     * Initialize list of available commands for interactive make.
     *
     * @return void
     */
    protected function initAvailableCommands()
    {
        $this->availableCommands = collect($this->getApplication()->all())
            ->filter(function (SymfonyCommand $command) {
                return $this->isEligibleCommand($command);
            })->map(function (Command $command) {
                return str_replace('make:', '', $command->getName());
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
        return in_array(str_replace('make:', '', $command), $this->illuminateCommands);
    }

    /**
     * Check if given command is eligible for interactive make.
     *
     * We allow only Laravel commands (not all Symfony Commands) which name
     * starts with 'make:' and is either Illuminate command or has proper
     * input collection method.
     *
     * @param SymfonyCommand $command
     * @return bool
     */
    private function isEligibleCommand(SymfonyCommand $command): bool
    {
        return $command instanceof Command
            && Str::startsWith($command->getName(), 'make:')
            && ($this->isIlluminateCommand($command->getName()) || $this->commandHasCollectMethod($command));
    }

    /**
     * Check if custom command has method for collecting arguments and options.
     *
     * We check if command has either method or macro called 'collectInputForInteractiveMake'.
     *
     * @param Command $command
     * @return bool
     */
    private function commandHasCollectMethod(Command $command): bool
    {
        if ($command::hasMacro('collectInputForInteractiveMake')) {
            return true;
        }

        $reflection = new \ReflectionClass($command);

        return $reflection->hasMethod('collectInputForInteractiveMake')
            && $reflection->getMethod('collectInputForInteractiveMake')->isPublic();
    }

    /**
     * Get arguments and options for Illuminate command.
     *
     * @param string $command
     * @return array
     */
    private function collectIlluminateCommandInput(string $command): array
    {
        $collectorClassName = $this->getIlluminateCommandInputCollectorClassName($command);

        if (class_exists($collectorClassName)) {
            return (new $collectorClassName())($this);
        }

        return [];
    }

    /**
     * Get Illuminate command input collector class name.
     *
     * @param string $command
     * @return string
     */
    private function getIlluminateCommandInputCollectorClassName(string $command): string
    {
        return "HydrefLab\\Laravel\\Make\\Console\\CommandInputCollectors\\" . ucfirst($command) . 'MakeCommandInputCollector';
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