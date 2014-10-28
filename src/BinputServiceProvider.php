<?php

/**
 * This file is part of Laravel Binput by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Binput;

use Illuminate\Support\ServiceProvider;

/**
 * This is the binput service provider class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-Binput/blob/master/LICENSE.md> Apache 2.0
 */
class BinputServiceProvider extends ServiceProvider
{
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
        $this->package('graham-campbell/binput', 'graham-campbell/binput', __DIR__);
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
