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

namespace GrahamCampbell\Tests\Binput\Functional;

use GrahamCampbell\Binput\Facades\Binput;
use GrahamCampbell\Tests\Binput\AbstractTestCase;
use Illuminate\Support\Facades\Route;

/**
 * This is the binput test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class BinputTest extends AbstractTestCase
{
    private $data;

    /**
     * @before
     */
    public function setUpData(): void
    {
        $this->data = false;
    }

    public function testAll(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::all();
        });

        $this->call('GET', 'binput-test-route', ['test' => '123', 'foo' => '<script>alert(\'bar\');</script>    ']);

        self::assertSame(['test' => '123', 'foo' => ''], $this->data);
    }

    public function testGet(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::get('foo');
        });

        $this->call('GET', 'binput-test-route', ['test' => 'abc', 'foo' => '<script>123</script>  <h1>HI!</h1>  ']);

        self::assertSame('<h1>HI!</h1>', $this->data);
    }

    public function testGetMany(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::get('bar');
        });

        $this->call('GET', 'binput-test-route', ['test' => 'abc', 'bar' => ['baz' => 4, [[5.4, '<script>']]]]);

        self::assertSame(['baz' => 4, [[5.4, '']]], $this->data);
    }

    public function testOnlyOne(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::only('foo');
        });

        $this->call('GET', 'binput-test-route', ['test' => '123', 'foo' => 'bar', 'baz' => 'qwerty']);

        self::assertSame(['foo' => 'bar'], $this->data);
    }

    public function testOnlyTwo(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::only(['foo', 'test']);
        });

        $this->call('GET', 'binput-test-route', ['test' => '123', 'foo' => 'bar', 'baz' => 'qwerty']);

        self::assertSame(['foo' => 'bar', 'test' => '123'], $this->data);
    }

    public function testOnlyEmpty(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::only(['bar']);
        });

        $this->call('GET', 'binput-test-route');

        self::assertSame(['bar' => null], $this->data);
    }

    public function testExceptOne(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::except('foo');
        });

        $this->call('GET', 'binput-test-route', ['foo' => 'herro', 'bar' => 'abc', 'baz' => 'qwerty']);

        self::assertSame(['bar' => 'abc', 'baz' => 'qwerty'], $this->data);
    }

    public function testExceptTwo(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::except(['foo', 'baz']);
        });

        $this->call('GET', 'binput-test-route', ['foo' => 'herro', 'bar' => 'abc', 'baz' => 'qwerty']);

        self::assertSame(['bar' => 'abc'], $this->data);
    }

    public function testMap(): void
    {
        Route::get('binput-test-route', function (): void {
            $this->data = Binput::map(['foo' => 'hi', 'baz' => 'bar']);
        });

        $this->call('GET', 'binput-test-route', ['foo' => 'herro', 'bar' => 'abc', 'baz' => 'qwerty']);

        self::assertSame(['hi' => 'herro', 'bar' => 'qwerty'], $this->data);
    }
}
