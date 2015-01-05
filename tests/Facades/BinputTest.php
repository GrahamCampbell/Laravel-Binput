<?php

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\Binput\Facades;

use GrahamCampbell\TestBench\Traits\FacadeTestCaseTrait;
use GrahamCampbell\Tests\Binput\AbstractTestCase;

/**
 * This is the binput facade test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class BinputTest extends AbstractTestCase
{
    use FacadeTestCaseTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'binput';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return 'GrahamCampbell\Binput\Facades\Binput';
    }

    /**
     * Get the facade route.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return 'GrahamCampbell\Binput\Binput';
    }
}
