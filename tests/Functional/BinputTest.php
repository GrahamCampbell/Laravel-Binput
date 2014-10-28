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

namespace GrahamCampbell\Tests\Binput\Functional;

use GrahamCampbell\Binput\Facades\Binput;
use GrahamCampbell\Tests\Binput\AbstractTestCase;
use Illuminate\Support\Facades\Route;

/**
 * This is the binput test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-Binput/blob/master/LICENSE.md> Apache 2.0
 */
class BinputTest extends AbstractTestCase
{
    public $data;

    /**
     * Run extra setup code.
     *
     * @return void
     */
    protected function start()
    {
        $this->data = false;
    }

    public function testAll()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::all();
        });

        $this->call('GET', 'binput-test-route', ['test' => '123', 'foo' => '<script>alert(\'bar\');</script>    ']);

        $this->assertSame(['test' => '123', 'foo' => '[removed]alert&#40;\'bar\'&#41;;[removed]'], $this->data);
    }

    public function testGet()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::get('foo');
        });

        $this->call('GET', 'binput-test-route', ['test' => 'abc', 'foo' => '<script>123</script>  <h1>HI!</h1>  ']);

        $this->assertSame('[removed]123[removed]  <h1>HI!</h1>', $this->data);
    }

    public function testOnlyOne()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::only('foo');
        });

        $this->call('GET', 'binput-test-route', ['test' => '123', 'foo' => 'bar', 'baz' => 'qwerty']);

        $this->assertSame(['foo' => 'bar'], $this->data);
    }

    public function testOnlyTwo()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::only(['foo', 'test']);
        });

        $this->call('GET', 'binput-test-route', ['test' => '123', 'foo' => 'bar', 'baz' => 'qwerty']);

        $this->assertSame(['foo' => 'bar', 'test' => '123'], $this->data);
    }

    public function testOnlyEmpty()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::only(['bar']);
        });

        $this->call('GET', 'binput-test-route');

        $this->assertSame(['bar' => null], $this->data);
    }

    public function testExceptOne()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::except('foo');
        });

        $this->call('GET', 'binput-test-route', ['foo' => 'herro', 'bar' => 'abc', 'baz' => 'qwerty']);

        $this->assertSame(['bar' => 'abc', 'baz' => 'qwerty'], $this->data);
    }

    public function testExceptTwo()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::except(['foo', 'baz']);
        });

        $this->call('GET', 'binput-test-route', ['foo' => 'herro', 'bar' => 'abc', 'baz' => 'qwerty']);

        $this->assertSame(['bar' => 'abc'], $this->data);
    }

    public function testMap()
    {
        Route::get('binput-test-route', function () {
            $this->data = Binput::map(['foo' => 'hi', 'baz' => 'bar']);
        });

        $this->call('GET', 'binput-test-route', ['foo' => 'herro', 'bar' => 'abc', 'baz' => 'qwerty']);

        $this->assertSame(['hi' => 'herro', 'bar' => 'qwerty'], $this->data);
    }

    public function testOld()
    {
        return $this->markTestSkipped('Input flashing is currently broken in laravel 5.0');

        Route::get('binput-test-flash', function () {
            Binput::flash();
        });

        $this->call('GET', 'binput-test-flash', ['foo' => '123', 'bar' => 'abc']);

        Route::get('binput-test-route', function () {
            $this->data = Binput::old('foo');
        });

        $this->call('GET', 'binput-test-route');

        $this->assertSame('123', $this->data);
    }
}
