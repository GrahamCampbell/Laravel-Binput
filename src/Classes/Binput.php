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
 * @license    https://github.com/GrahamCampbell/Laravel-Binput/blob/master/LICENSE.md
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
     * Get all of the input and files for the request.
     *
     * @param  bool  $trim
     * @param  bool  $clean
     * @return array
     */
    public function all($trim = true, $clean = true)
    {
        $values = $this->request->all();

        return $this->clean($values, $trim, $clean);
    }

    /**
     * Get an input item from the request.
     *
     * @param  string  $key
     * @param  string  $default
     * @param  bool    $trim
     * @param  bool    $clean
     * @return mixed
     */
    public function get($key = null, $default = null, $trim = true, $clean = true)
    {
        $value = $this->request->input($key, $default);

        return $this->clean($value, $trim, $clean);
    }

    /**
     * Get all the input from the request.
     *
     * @param  string  $key
     * @param  string  $default
     * @param  bool    $trim
     * @param  bool    $clean
     * @return mixed
     */
    public function input($key = null, $default = null, $trim = true, $clean = true)
    {
        return $this->get($key, $default, $trim, $clean);
    }

    /**
     * Get a subset of the items from the input data.
     *
     * @param  array|string  $keys
     * @param  bool          $trim
     * @param  bool          $clean
     * @return array
     */
    public function only($keys, $trim = true, $clean = true)
    {
        $values = $this->request->only($keys);

        return $this->clean($values, $trim, $clean);
    }

    /**
     * Get all of the input except for a specified array of items.
     *
     * @param  array|string  $keys
     * @param  bool          $trim
     * @param  bool          $clean
     * @return array
     */
    public function except($keys, $trim = true, $clean = true)
    {
        $values = $this->request->except($keys);

        return $this->clean($values, $trim, $clean);
    }

    /**
     * Get a mapped subset of the items from the input data.
     *
     * @param  array|string  $keys
     * @param  bool          $trim
     * @param  bool          $clean
     * @return array
     */
    public function map($keys, $trim = true, $clean = true)
    {
        $values = $this->only(array_keys($keys), $trim, $clean);

        $new = array();
        foreach ($keys as $key => $value) {
            $new[$value] = array_get($values, $key);
        }

        return $new;
    }

    /**
     * Get an old input item from the request.
     *
     * @param  array|string  $keys
     * @param  string        $default
     * @param  bool          $trim
     * @param  bool          $clean
     * @return mixed
     */
    public function old($keys = null, $default = null, $trim = true, $clean = true)
    {
        $value = $this->request->old($keys, $default);

        return $this->clean($value, $trim, $clean);
    }

    /**
     * Clean a specified value or values.
     *
     * @param  mixed  $value
     * @param  bool   $trim
     * @param  bool   $clean
     * @return mixed
     */
    public function clean($value, $trim = true, $clean = true)
    {
        $final = null;

        if (!is_null($value)) {
            if (is_array($value)) {
                $all = $value;
                $final = array();
                foreach ($all as $key => $value) {
                    if (!is_null($value)) {
                        $final[$key] = $this->clean($value, $trim, $clean);
                    }
                }
            } else {
                if (!is_null($value)) {
                    $final = $this->process($value, $trim, $clean);
                }
            }
        }

        return $final;
    }

    /**
     * Process a specified value.
     *
     * @param  mixed  $value
     * @param  bool   $trim
     * @param  bool   $clean
     * @return mixed
     */
    protected function process($value, $trim = true, $clean = true)
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
     * Set the request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function setRequest(Request $request)
    {
        return $this->request = $request;
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

    /**
     * Dynamically call all other methods on the request object.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->request, $method), $parameters);
    }
}
