<?php

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\Binput;

use GrahamCampbell\TestBench\AbstractLaravelTestCase;

/**
 * This is the abstract test case class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    /**
     * Get the required service providers.
     *
     * @return string[]
     */
    protected function getRequiredServiceProviders()
    {
        return [
            'GrahamCampbell\Security\SecurityServiceProvider',
        ];
    }

    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return 'GrahamCampbell\Binput\BinputServiceProvider';
    }
}
