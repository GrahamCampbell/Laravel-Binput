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

namespace GrahamCampbell\Tests\Binput\Classes;

use Mockery;
use GrahamCampbell\Binput\Classes\Binput;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the binput test class.
 *
 * @package    Laravel-Binput
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Binput/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Binput
 */
class BinputTest extends AbstractTestCase
{
    public function testAll()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('all')->once()->andReturn(array('test' => '123'));
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->all();

        $this->assertEquals(array('test' => '123'), $return);
    }

    public function testGet()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->get('test');

        $this->assertEquals('123', $return);
    }

    public function testInput()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('input')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->input('test');

        $this->assertEquals('123', $return);
    }

    public function testOnly()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('only')->with('test')->once()->andReturn(array('test' => '123'));
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->only('test');

        $this->assertEquals(array('test' => '123'), $return);
    }

    public function testExcept()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('except')->with('abc')->once()->andReturn(array('test' => '123'));
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->except('abc');

        $this->assertEquals(array('test' => '123'), $return);
    }

    public function testMapBasic()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('only')->with(array('test'))->once()->andReturn(array('test' => '123'));
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->map(array('test' => 'new'));

        $this->assertEquals(array('new' => '123'), $return);
    }

    public function testOld()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('old')->with('test', null)->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->old('test');

        $this->assertEquals('123', $return);
    }

    public function testCleanBasic()
    {
        $binput = $this->getBinput();

        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->clean('123');

        $this->assertEquals('123', $return);
    }

    public function testCleanNested()
    {
        $binput = $this->getBinput();

        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');
        $binput->getSecurity()->shouldReceive('clean')->with('abc')->once()->andReturn('abc');

        $return = $binput->clean(array(array('123  '), 'abc'));

        $this->assertEquals(array(array('123'), 'abc'), $return);
    }

    public function testCleanEmpty()
    {
        $binput = $this->getBinput();

        $return = $binput->clean(null);

        $this->assertEquals(null, $return);
    }

    public function testProcessTrue()
    {
        $binput = $this->getBinput();

        $binput->getSecurity()->shouldReceive('clean')->with('123')->once()->andReturn('123');

        $return = $binput->clean('123  ');

        $this->assertEquals('123', $return);
    }

    public function testProcessFalse()
    {
        $binput = $this->getBinput();

        $return = $binput->clean('123  ', false, false);

        $this->assertEquals('123  ', $return);
    }

    public function testDynamicRequestCall()
    {
        $binput = $this->getBinput();

        $binput->getRequest()->shouldReceive('flash')->with('123')->once();

        $return = $binput->flash('123');

        $this->assertEquals(null, $return);
    }

    protected function getBinput()
    {
        $request = Mockery::mock('Illuminate\Http\Request');
        $security = Mockery::mock('GrahamCampbell\Security\Classes\Security');

        return new Binput($request, $security);
    }
}
