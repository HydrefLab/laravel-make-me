# Extendable Interactive Make Command for Laravel

## Installation

```bash
composer require hydreflab/laravel-make-me`
```

### Laravel >= 5.5

Package uses Laravel auto-discovery feature, so no service provider registration is needed.

### Laravel <= 5.4

Manual service provider registration is required in `config/app.php`:

```bash
'providers' => [
    // ...
    
    HydrefLab\Laravel\Make\MakeServiceProvider::class,
]
```

*Note: PHP >= 7.0 is required to run this package*

## Usage

To use interactive make, just run:

```bash
php artisan make
```

After that, you'll be asked what kind of class do you want to generate. Then, you'll be asked a 
series of questions in order to prepare class that suits your needs.

Interactive make integrates all default Laravel generator commands.

If you want to check what's available, simply run:

```
php artisan make --list
```

## Why

Laravel's Artisan is a great tool. Laravel's generators (make) commands are great tools. Quite 
often they have a lot of additional options available. However, without checking out the command's 
code or run command with `--help` option, it is a mystery what additional stuff particular
command can do. That's why I created this interactive make command. Enjoy!

[Edit]: I recently noticed that there is a similar [package](https://github.com/laracademy/interactive-make) that also
adds interactive make. Check that out, maybe it will suit you better.

## Preview

![Preview](preview.gif)

## Extendability

Quite often, as project advances, you end up in a situation that you're creating your own generator
commands, your own _make:something_. It would be awesome if this new command could be included
in the interactive make. Hey, that's possible.

To add custom (non-default) generator command to the interactive make:
* command has to have `public collectInputForInteractiveMake()` method implemented,
* `collectInputForInteractiveMake` method must return an array,
* command must extend `Illuminate\Console\Command` class (since it is make-like command, I recommend to extend `Illuminate\Console\GeneratorCommand`),
* command name must contain `make:` prefix, for example `make:awesome`.

Example:
```php
<?php

class MyAwesomeMakeCommand extends \Illuminate\Console\Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:awesome';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new awesome class';
    

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Generate something awesome
    }
    
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Your awesome name'],
        ];
    }
    
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['scale', 's', InputOption::VALUE_NONE, 'Awesomeness scale.'],
        ];
    }
    
    /**
     * Collect options for the interactive make command.
     * 
     * @return array
     */
    public function collectInputForInteractiveMake()
    {
        return [
            'name' => $this->ask('What is your name, awesome?'),
            '-s' => $this->ask('How awesome are you?', 10),
        ];
    }
}
```

That's it. `MyAwesomeMakeCommand` command will now be included in the interactive make as `awesome`.