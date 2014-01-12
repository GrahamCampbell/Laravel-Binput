<?php

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
 */

namespace GrahamCampbell\Binput\Classes;

use Illuminate\Http\Request;
use GrahamCampbell\Security\Classes\Security;

/**
 * This is the binput class.
 *
 * @package    Laravel-Binput
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Binput/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Binput
 */
class Binput
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The security instance.
     *
     * @var \GrahamCampbell\Security\Classes\Security
     */
    protected $security;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \GrahamCampbell\Security\Classes\Security  $security
     * @return void
     */
    public function __construct(Request $request, Security $security)
    {
        $this->request = $request;
        $this->security = $security;
    }

    /**
     * Get all the input.
     *
     * @param  bool  $trim
     * @param  bool  $clean
     * @return array
     */
    public function all($trim = true, $clean = true)
    {
        $all = $this->request->input();

        $values = array();

        foreach ($all as $key => $value) {
            if (!is_null($value)) {
                $values[$key] = $this->clean($value, $trim, $clean);
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
     * @param  bool    $clean
     * @return mixed
     */
    public function get($key, $default = null, $trim = true, $clean = true)
    {
        $value = $this->request->input($key, $default);

        if (!is_null($value)) {
            $value = $this->clean($value, $trim, $clean);
        }

        return $value;
    }

    /**
     * Clean a specified value.
     *
     * @param  mixed  $value
     * @param  bool   $trim
     * @param  bool   $clean
     * @return mixed
     */
    public function clean($value, $trim = true, $clean = true)
    {
        if ($trim === true && is_string($value)) {
            $value = trim($value);
        }

        if ($clean === true) {
            $value = $this->security->clean($value);
        }

        return $value;
    }

    /**
     * Return the request instance.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Return the security instance.
     *
     * @return \GrahamCampbell\Security\Classes\Security
     */
    public function getSecurity()
    {
        return $this->security;
    }
}
