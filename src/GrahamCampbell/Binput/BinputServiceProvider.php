<?php namespace GrahamCampbell\Binput;

use Illuminate\Support\ServiceProvider;

class BinputServiceProvider extends ServiceProvider {

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
    public function boot() {
        $this->package('graham-campbell/binput');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['binput'] = $this->app->share(function($app) {
            return new Classes\Binput;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }
}
