<?php

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\Binput;

use GrahamCampbell\Binput\Binput;
use GrahamCampbell\Security\Security;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Illuminate\Http\Request;
use Mockery;

/**
 * This is the binput test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class BinputTest extends AbstractTestBenchTestCase
{
    public function testAll()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('all')->once()->andReturn(['test' => '123']);
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->all();

        $this->assertSame(['test' => '123'], $return);
    }

    public function testGet()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->get('test');

        $this->assertSame('123', $return);
    }

    public function testInput()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->input('test');

        $this->assertSame('123', $return);
    }

    public function testOnlyOne()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->only('test');

        $this->assertSame(['test' => '123'], $return);
    }

    public function testOnlyTwo()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getRequest()->shouldReceive('input')->with('bar', null)->once()->andReturn('baz');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('baz')->once()->andReturn('baz');

        $return = $binput->only(['test', 'bar']);

        $this->assertSame(['test' => '123', 'bar' => 'baz'], $return);
    }

    public function testOnlyEmpty()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn(null);

        $return = $binput->only(['test']);

        $this->assertSame(['test' => null], $return);
    }

    public function testExceptOne()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('except')->with(['abc'])->once()->andReturn(['test' => '123']);
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->except('abc');

        $this->assertSame(['test' => '123'], $return);
    }

    public function testExceptTwo()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('except')->with(['abc', 'qwerty'])->once()->andReturn(['test' => '123']);
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->except(['abc', 'qwerty']);

        $this->assertSame(['test' => '123'], $return);
    }

    public function testMap()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->map(['test' => 'new']);

        $this->assertSame(['new' => '123'], $return);
    }

    public function testOld()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('old')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->old('test');

        $this->assertSame('123', $return);
    }

    public function testCleanBasic()
    {
        $binput = $this->getBinput();

        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->clean('123');

        $this->assertSame('123', $return);
    }

    public function testCleanNested()
    {
        $binput = $this->getBinput();

        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('abc')->once()->andReturn('abc');

        $return = $binput->clean([['123  '], 'abc']);

        $this->assertSame([['123'], 'abc'], $return);
    }

    public function testCleanEmpty()
    {
        $binput = $this->getBinput();

        $return = $binput->clean(null);

        $this->assertSame(null, $return);
    }

    public function testProcessTrue()
    {
        $binput = $this->getBinput();

        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->clean('123  ');

        $this->assertSame('123', $return);
    }

    public function testProcessFalse()
    {
        $binput = $this->getBinput();

        $return = $binput->clean('123  ', false, false);

        $this->assertSame('123  ', $return);
    }

    public function testDynamicRequestCall()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('flash')->with('123')->once();

        $return = $binput->flash('123');

        $this->assertSame(null, $return);
    }

    public function testSetRequest()
    {
        $binput = $this->getBinput();

        $request = new Request();

        $binput->setRequest($request);

        $return = $binput->getRequest();

        $this->assertSame($request, $return);
    }

    protected function getBinput()
    {
        $request = Mockery::mock(Request::class);
        $security = Mockery::mock(Security::class);

        return new Binput($request, $security);
    }
}
