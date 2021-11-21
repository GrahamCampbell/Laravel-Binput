<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Binput;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

/**
 * This is the binput service provider class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
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
        $this->registerBinput();
    }

    /**
     * Register the binput class.
     *
     * @return void
     */
    protected function registerBinput()
    {
        $this->app->singleton('binput', function (Container $app) {
            $request = $app['request'];
            $security = $app['security'];

            $binput = new Binput($request, $security);
            $app->refresh('request', $binput, 'setRequest');

            return $binput;
        });

        $this->app->alias('binput', Binput::class);
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
