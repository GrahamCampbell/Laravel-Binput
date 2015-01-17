<?php

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Binput;

use Orchestra\Support\Providers\ServiceProvider;

/**
 * This is the binput service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class BinputServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBinput();
    }

    /**
     * Register the binput class.
     *
     * @return void
     */
    protected function registerBinput()
    {
        $this->app->singleton('binput', function ($app) {
            $request = $app['request'];
            $security = $app['security'];

            $binput = new Binput($request, $security);
            $app->refresh('request', $binput, 'setRequest');

            return $binput;
        });

        $this->app->alias('binput', 'GrahamCampbell\Binput\Binput');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'binput',
        ];
    }
}
