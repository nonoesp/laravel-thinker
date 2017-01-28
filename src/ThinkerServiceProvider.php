<?php namespace Nonoesp\Thinker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

class ThinkerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish Paths
        $publish_path_views = base_path('resources/views/nonoesp/thinker');
        $publish_path_lang = base_path('resources/lang/nonoesp/thinker');
        $publish_path_middleware = base_path('app/Http/Middleware');

        // Publish Stuff
        $this->publishes([__DIR__.'/../views' => $publish_path_views,], 'views');
        $this->publishes([__DIR__.'/../lang' => $publish_path_lang,], 'lang');
        $this->publishes([__DIR__.'/Middleware' => $publish_path_middleware,], 'middleware');

        // Views
        if (is_dir($publish_path_views)) {
            $this->loadViewsFrom($publish_path_views, 'thinker'); // Load published views
        } else {
            $this->loadViewsFrom(__DIR__ . '/../views', 'thinker');
        }

        // Translations
        if (is_dir($publish_path_lang)) {
            $this->loadTranslationsFrom($publish_path_lang, 'thinker'); // Load published lang
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../lang', 'thinker');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        // include __DIR__.'/routes.php';

        // Create alias
        // $this->app->booting(function()
        // {
        //   $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        //   $loader->alias('Thinker', 'Nonoesp\Thinker\Facades\Thinker');
        // });

        $this->app->singleton('thinker', function (Container $app) {
             return new Thinker();
         });
        $this->app->alias('thinker', Thinker::class);

    }
}
