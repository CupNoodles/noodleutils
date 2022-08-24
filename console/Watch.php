<?php

namespace CupNoodles\NoodleUtils\Console;

use System\Console\Commands\IgniterUtil;
use System\Facades\Assets;
use System\Libraries\Assets as AssetsManager;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;

use Igniter\Flame\Support\Facades\File;

use Main\Classes\ThemeManager;

class Watch extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'noodle:watch';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Compile watch js and scss assets.';

    /**
     * handle watching for asset changes
     * bundle paths must be in src/
     */
    public function handle()
    {

        // this is a pretty big assumption - change this if your bundles are in a different place as defined in assets.json
        $watch_dir = theme_path(active_theme() . '/assets/src/'  ); echo $watch_dir;

        // compile once before starting the listener
        $this->compile();

        $files = new \Illuminate\Filesystem\Filesystem;
        $tracker = new \JasonLewis\ResourceWatcher\Tracker;
        $watcher = new \JasonLewis\ResourceWatcher\Watcher($tracker, $files);


        $listener = $watcher->watch($watch_dir);
        

        $listener->onModify(function($resource, $path) {
            $this->compile($path);
        });

        // 0.5 second poll time
        $watcher->start(500000);
    }

    public function compile($path = null){

        try{

            if($path != null){
                $this->comment("{$path} modified.");
            }

            Event::listen('assets.combiner.beforePrepare', function (AssetsManager $combiner, $assets) {
                ThemeManager::applyAssetVariablesOnCombinerFilters(
                    array_flatten($combiner->getFilters()), ThemeManager::instance()->getActiveTheme()
                );
            });

            $this->comment("Compiling Javascript Assets");
            Artisan::call('igniter:util', [ 'name' => 'CompileJS']);
            $this->comment("Javascript Assets Compiled");

            $this->comment("Compiling SCSS assets to CSS");
            Artisan::call('igniter:util', [ 'name' => 'CompileSCSS']);
            $this->comment("SCSS compied to CSS");

            
        }
        catch( \Exception $e){
            $this->alert($e->getMessage());
        }



    
    }


}
