<?php namespace Cubet\Ebay;

use Illuminate\Support\ServiceProvider;

class EbayServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
        
        public function boot()
        {
            $this->package('cubet/ebay');
            
            include __DIR__.'/../../config/routes.php';
        }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['ebay'] = $this->app->share(function($app)
                {
                    return new Ebay($app['view']);
                });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('ebay');
	}

}