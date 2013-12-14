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

use Illuminate\Http\Request;
use GrahamCampbell\Security\Classes\Security;

class Binput extends Request
{

    /**
     * The security instance.
     *
     * @var \GrahamCampbell\Security\Classes\Security
     */
    protected $security;

    /**
     * Create a new instance.
     *
     * @param  \GrahamCampbell\Security\Classes\Security  $security
     * @return void
     */
    public function __construct(Security $security)
    {
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
        $all = $this->input();

        $values = array();

        foreach ($all as $value) {
            if (!is_null($value)) {
                if ($trim === true && is_string($value)) {
                    $value = trim($value);
                }

                if ($clean === true) {
                    $value = $this->security->clean($value);
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
     * @param  bool    $clean
     * @return mixed
     */
    public function get($key, $default = null, $trim = true, $clean = true)
    {
        $value = $this->input($key, $default);

        if (!is_null($value)) {
            if ($trim === true && is_string($value)) {
                $value = trim($value);
            }

            if ($clean === true) {
                $value = $this->security->clean($value);
            }

            return $value;
        }
    }
}
