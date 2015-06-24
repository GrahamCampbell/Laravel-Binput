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
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testBinputIsInjectable()
    {
        $this->assertIsInjectable(Binput::class);
    }
}
