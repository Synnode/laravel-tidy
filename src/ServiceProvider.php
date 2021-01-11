<?php namespace Synnode\HtmlTidy;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['synnode.tidy'];
	}

	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function register()
	{
		// Merge user's configuration
		$this->mergeConfigFrom(__DIR__ . '/config.php', 'tidy');

		// Bind 'synnode.tidy' shared component to the IoC container
		$this->app->singleton('synnode.tidy', function ($app) {
			return new Tidy($app['config']['tidy']);
		});
	}

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Register paths to be published by 'vendor:publish' artisan command
		$this->publishes([
			__DIR__ . '/config.php' => config_path('tidy.php'),
		]);
	}
}
