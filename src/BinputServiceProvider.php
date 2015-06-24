<?php

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Binput;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * This is the binput service provider class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class BinputServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBinput($this->app);
    }

    /**
     * Register the binput class.
     *
     * @param Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerBinput(Application $app)
    {
        $app->singleton('binput', function ($app) {
            $request = $app['request'];
            $security = $app['security'];

            $binput = new Binput($request, $security);
            $app->refresh('request', $binput, 'setRequest');

            return $binput;
        });

        $app->alias('binput', Binput::class);
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
