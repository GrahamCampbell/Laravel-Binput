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

use GrahamCampbell\Binput\BinputServiceProvider;
use GrahamCampbell\Security\SecurityServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

/**
 * This is the abstract test case class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the required service providers.
     *
     * @return string[]
     */
    protected static function getRequiredServiceProviders(): array
    {
        return [
            SecurityServiceProvider::class,
        ];
    }

    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected static function getServiceProviderClass(): string
    {
        return BinputServiceProvider::class;
    }
}
