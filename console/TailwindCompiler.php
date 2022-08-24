<?php

namespace CupNoodles\NoodleUtils\Console;

use Igniter\Flame\Support\Facades\File;
use Illuminate\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;


class TailwindCompiler extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'noodle:tailwind';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Tailwind utility commands.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $command = implode(' ', (array)$this->argument('name'));
        $method = 'util'.studly_case($command);

        if (!method_exists($this, $method)) {
            $this->error(sprintf('Utility command "%s" does not exist!', $command));

            return;
        }

        $this->$method();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The utility command to perform.'],
        ];
    }

    protected function utilCompileTailwindCSS(){
        echo 'hi';
    }


}
