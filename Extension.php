<?php 

namespace CupNoodles\NoodleUtils;
use System\Classes\BaseExtension;
use System\Classes\ExtensionManager;

use System\ServiceProvider;



class Extension extends BaseExtension
{

    public function boot()
    {

    }

    public function register()
    {

        $this->registerConsoleCommand(
            'noodle.watch', \CupNoodles\NoodleUtils\Console\Watch::class
        );

        $this->registerConsoleCommand(
            'noodle.tailwind', \CupNoodles\NoodleUtils\Console\TailwindCompiler::class
        );
    }
}
