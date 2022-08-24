## CupNoodles Utility Commands for TastyIgniter


### Asset watcher

`php artisan noodle:watch` is a `assets/src/` directory watcher that runs `igniter:util CompileJS` and `igniter:util CompileSCSS` on any change to the `assets/src/` folder. 

Please note that it assumes a standard directory structure on your main theme and isn't pulling asset bundle paths from your `assets.json`. Update the code in `Watch.php` if you're using non-standard asset paths. 

Also note! Unlinke running `igniter:util CompileSCSS`, `noodle:watch` will compile theme variables into your CSS. This can lead to you having undefined variables in your SCSS that are only set through the them editor, causing such themes to fail to compile unless you're diligent about setting default values. 