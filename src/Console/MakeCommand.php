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
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Interactive Make!');
    }
}