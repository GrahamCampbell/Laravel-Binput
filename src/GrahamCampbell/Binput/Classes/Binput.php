<?php namespace GrahamCampbell\Binput\Classes;

/**
 * This file is part of Laravel Binput by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    Laravel-Binput
 * @author     Graham Campbell
 * @license    Apache License
 * @copyright  Copyright 2013 Graham Campbell
 * @link       https://github.com/GrahamCampbell/Laravel-Binput
 */

class Binput {

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * Get all the input.
     *
     * @param  bool    $trim
     * @param  bool    $xss_clean
     * @return array
     */
    public function all($trim = true, $xss_clean = true) {
        $all = $this->app['request']->input();

        $values = array();

        foreach ($all as $value) {
            if (!is_null($value)) {
                if ($trim === true && is_string($value)) {
                    $value = trim($value);
                }

                if ($xss_clean === true) {
                    $value = $this->app['security']->xss_clean($value);
                }

                $values[] = $value;
            }
        }

        return $values;
    }

    /**
     * Get the specified input.
     *
     * @param  string  $key
     * @param  string  $default
     * @param  bool    $trim
     * @param  bool    $xss_clean
     * @return mixed
     */
    public function get($key, $default = null, $trim = true, $xss_clean = true) {
        $value = $app['request']->input($key, $default);

        if (!is_null($value)) {
            if ($trim === true && is_string($value)) {
                $value = trim($value);
            }

            if ($xss_clean === true) {
                $value = $this->app['security']->xss_clean($value);
            }

            return $value;
        }
    }
}
