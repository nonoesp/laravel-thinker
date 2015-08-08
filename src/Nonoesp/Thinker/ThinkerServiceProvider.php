<?php namespace Nonoesp\Thinker;

use Illuminate\Support\ServiceProvider;

class ThinkerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('nonoesp/thinker');

    	include __DIR__.'/routes.php';		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  $loader->alias('Thinker', 'Nonoesp\Thinker\Facades\Thinker');
		});

		$this->app['thinker'] = $this->app->share(function($app)
		{
		return new Thinker;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('thinker');
	}

}
