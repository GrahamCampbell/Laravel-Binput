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

namespace GrahamCampbell\Tests\Binput;

use GrahamCampbell\Binput\Binput;
use GrahamCampbell\SecurityCore\Security;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Illuminate\Http\Request;
use Mockery;

/**
 * This is the binput test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class BinputTest extends AbstractTestBenchTestCase
{
    public function testAll(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('all')->once()->andReturn(['test' => '123']);
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->all();

        self::assertSame(['test' => '123'], $return);
    }

    public function testGet(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->get('test');

        self::assertSame('123', $return);
    }

    public function testInput(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->input('test');

        self::assertSame('123', $return);
    }

    public function testOnlyOne(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->only('test');

        self::assertSame(['test' => '123'], $return);
    }

    public function testOnlyTwo(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $request->shouldReceive('input')->with('bar', null)->once()->andReturn('baz');
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');
        $security->shouldReceive('clean')->with('baz')->once()->andReturn('baz');

        $return = $binput->only(['test', 'bar']);

        self::assertSame(['test' => '123', 'bar' => 'baz'], $return);
    }

    public function testOnlyEmpty(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('input')->with('test', null)->once()->andReturn(null);

        $return = $binput->only(['test']);

        self::assertSame(['test' => null], $return);
    }

    public function testExceptOne(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('except')->with(['abc'])->once()->andReturn(['test' => '123']);
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->except('abc');

        self::assertSame(['test' => '123'], $return);
    }

    public function testExceptTwo(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('except')->with(['abc', 'qwerty'])->once()->andReturn(['test' => '123']);
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->except(['abc', 'qwerty']);

        self::assertSame(['test' => '123'], $return);
    }

    public function testMap(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->map(['test' => 'new']);

        self::assertSame(['new' => '123'], $return);
    }

    public function testOld(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('old')->with('test', null)->once()->andReturn('123');
        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->old('test');

        self::assertSame('123', $return);
    }

    public function testCleanBasic(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->clean('123');

        self::assertSame('123', $return);
    }

    public function testCleanNested(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');
        $security->shouldReceive('clean')->with('abc')->once()->andReturn('abc');

        $return = $binput->clean([['123  '], 'abc']);

        self::assertSame([['123'], 'abc'], $return);
    }

    public function testCleanEmpty(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $return = $binput->clean(null);

        self::assertSame(null, $return);
    }

    public function testCleanScalar(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $array = $binput->clean([123, true, false, 1.4]);
        $integer = $binput->clean(123);
        $boolean1 = $binput->clean(true);
        $boolean2 = $binput->clean(false);
        $float = $binput->clean(1.4);

        self::assertSame([123, true, false, 1.4], $array);
        self::assertSame(123, $integer);
        self::assertSame(true, $boolean1);
        self::assertSame(false, $boolean2);
        self::assertSame(1.4, $float);
    }

    public function testProcessTrue(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $security->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->clean('123  ');

        self::assertSame('123', $return);
    }

    public function testProcessFalse(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $return = $binput->clean('123  ', false, false);

        self::assertSame('123  ', $return);
    }

    public function testDynamicRequestCall(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request->shouldReceive('flash')->with('123')->once();

        $return = $binput->flash('123');

        self::assertSame(null, $return);
    }

    public function testSetRequest(): void
    {
        [$request, $security, $binput] = self::getMocks();

        $request = new Request();

        $binput->setRequest($request);

        $return = $request;

        self::assertSame($request, $return);
    }

    private static function getMocks(): array
    {
        $request = Mockery::mock(Request::class);
        $security = Mockery::mock(Security::class);
        $binput = new Binput($request, $security);

        return [$request, $security, $binput];
    }
}
