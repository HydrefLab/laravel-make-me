<?php

namespace HydrefLab\Laravel\Make\Console\CommandOptionsCollectors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrationMakeCommandOptionsCollector
{
    /**
     * @param Command $command
     * @return array
     */
    public function __invoke(Command $command): array
    {
        $options = $command->confirm('Are you creating new table?')
            ? $this->collectCrateTableOptions($command)
            : $this->collectAlterTableOptions($command);

        if (!$command->confirm('Create migration in default migration folder?', 'yes')) {
            $options['--path'] = $command->ask('Path for migration file');
        }

        return $options;
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectCrateTableOptions(Command $command): array
    {
        $table = $command->ask('New table name');

        return [
            'name' => $command->ask('Migration name', 'create_' . Str::snake($table) .'_table'),
            '--create' => $table,
        ];
    }

    /**
     * @param Command $command
     * @return array
     */
    private function collectAlterTableOptions(Command $command): array
    {
        $table = $command->ask('Table name for edit');

        return [
            'name' => $command->ask('Migration name', 'alter_' . Str::snake($table) .'_table'),
            '--table' => $table,
        ];
    }
}