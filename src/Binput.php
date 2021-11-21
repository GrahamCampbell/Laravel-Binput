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

use GrahamCampbell\SecurityCore\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * This is the binput class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
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
     * @var \GrahamCampbell\SecurityCore\Security
     */
    protected $security;

    /**
     * Create a new instance.
     *
     * @param \Illuminate\Http\Request              $request
     * @param \GrahamCampbell\SecurityCore\Security $security
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
     * @return array
     */
    public function all(bool $trim = true, bool $clean = true)
    {
        $values = $this->request->all();

        return $this->clean($values, $trim, $clean);
    }

    /**
     * Get an input item from the request.
     *
     * @param string $key
     * @param mixed  $default
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return mixed
     */
    public function get(string $key, $default = null, bool $trim = true, bool $clean = true)
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
     * @param mixed  $default
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return mixed
     */
    public function input(string $key, $default = null, bool $trim = true, bool $clean = true)
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
     * @return array
     */
    public function only($keys, bool $trim = true, bool $clean = true)
    {
        $values = [];
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
     * @return array
     */
    public function except($keys, bool $trim = true, bool $clean = true)
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
     * @return array
     */
    public function map(array $keys, bool $trim = true, bool $clean = true)
    {
        $values = $this->only(array_keys($keys), $trim, $clean);

        $new = [];
        foreach ($keys as $key => $value) {
            $new[$value] = Arr::get($values, $key);
        }

        return $new;
    }

    /**
     * Get an old input item from the request.
     *
     * @param string $key
     * @param mixed  $default
     * @param bool   $trim
     * @param bool   $clean
     *
     * @return mixed
     */
    public function old(string $key, $default = null, bool $trim = true, bool $clean = true)
    {
        $value = $this->request->old($key, $default);

        return $this->clean($value, $trim, $clean);
    }

    /**
     * Clean a specified value or values.
     *
     * @param mixed $value
     * @param bool  $trim
     * @param bool  $clean
     *
     * @return mixed
     */
    public function clean($value, bool $trim = true, bool $clean = true)
    {
        if ($value === null || is_bool($value) || is_int($value) || is_float($value)) {
            return $value;
        }

        if (!is_array($value)) {
            return $this->process((string) $value, $trim, $clean);
        }

        $final = [];

        foreach ($value as $k => $v) {
            if ($v !== null) {
                $final[$k] = $this->clean($v, $trim, $clean);
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
    protected function process(string $value, bool $trim, bool $clean)
    {
        if ($trim) {
            $value = trim($value);
        }

        if ($clean) {
            $value = $this->security->clean($value);
        }

        if ($trim) {
            $value = trim($value);
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
     * @return \GrahamCampbell\SecurityCore\Security
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
    public function __call(string $method, array $parameters)
    {
        return $this->request->$method(...$parameters);
    }
}
