<?php

/*
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

use GrahamCampbell\Security\Security;
use Illuminate\Http\Request;

/**
 * This is the binput class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-Binput/blob/master/LICENSE.md> Apache 2.0
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
     * @var \GrahamCampbell\Security\Security
     */
    protected $security;

    /**
     * Create a new instance.
     *
     * @param \Illuminate\Http\Request          $request
     * @param \GrahamCampbell\Security\Security $security
     *
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
     * @param bool $trim
     * @param bool $clean
     *
     * @return string[]
     */
    public function all($trim = true, $clean = true)
    {
        $values = $this->request->all();

        return $this->clean($values, $trim, $clean);
    }

    /**
     * Get an input item from the request.
     *
     * @param string $key
     * @param string $default
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return string
     */
    public function get($key, $default = null, $trim = true, $clean = true)
    {
        $value = $this->request->input($key, $default);

        return $this->clean($value, $trim, $clean);
    }

    /**
     * Get an input item from the request.
     *
     * This is an alias to the get method.
     *
     * @param string $key
     * @param string $default
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return string
     */
    public function input($key, $default = null, $trim = true, $clean = true)
    {
        return $this->get($key, $default, $trim, $clean);
    }

    /**
     * Get a subset of the items from the input data.
     *
     * @param string|string[] $keys
     * @param bool            $trim
     * @param bool            $clean
     *
     * @return string[]
     */
    public function only($keys, $trim = true, $clean = true)
    {
        $values = array();
        foreach ((array) $keys as $key) {
            $values[$key] = $this->get($key, null, $trim, $clean);
        }

        return $values;
    }

    /**
     * Get all of the input except for a specified array of items.
     *
     * @param string|string[] $keys
     * @param bool            $trim
     * @param bool            $clean
     *
     * @return string[]
     */
    public function except($keys, $trim = true, $clean = true)
    {
        $values = $this->request->except((array) $keys);

        return $this->clean($values, $trim, $clean);
    }

    /**
     * Get a mapped subset of the items from the input data.
     *
     * @param string[] $keys
     * @param bool     $trim
     * @param bool     $clean
     *
     * @return string[]
     */
    public function map(array $keys, $trim = true, $clean = true)
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
     * @param string $key
     * @param string $default
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return string
     */
    public function old($key, $default = null, $trim = true, $clean = true)
    {
        $value = $this->request->old($key, $default);

        return $this->clean($value, $trim, $clean);
    }

    /**
     * Clean a specified value or values.
     *
     * @param string|string[] $value
     * @param bool            $trim
     * @param bool            $clean
     *
     * @return string|string[]
     */
    public function clean($value, $trim = true, $clean = true)
    {
        $final = null;

        if ($value !== null) {
            if (is_array($value)) {
                $all = $value;
                $final = array();
                foreach ($all as $key => $value) {
                    if ($value !== null) {
                        $final[$key] = $this->clean($value, $trim, $clean);
                    }
                }
            } else {
                if ($value !== null) {
                    $final = $this->process((string) $value, $trim, $clean);
                }
            }
        }

        return $final;
    }

    /**
     * Process a specified value.
     *
     * @param string $value
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return string
     */
    protected function process($value, $trim = true, $clean = true)
    {
        if ($trim) {
            $value = trim($value);
        }

        if ($clean) {
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
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the security instance.
     *
     * @return \GrahamCampbell\Security\Security
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Dynamically call all other methods on the request object.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->request, $method), $parameters);
    }
}
