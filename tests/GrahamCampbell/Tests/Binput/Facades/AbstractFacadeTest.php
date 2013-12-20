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

namespace GrahamCampbell\Tests\Binput\Facades;

use GrahamCampbell\Tests\Binput\AbstractTestCase;
use GrahamCampbell\TestBench\Traits\FacadeTestCaseTrait;

/**
 * This is the abstract facade test case class.
 *
 * @package    Laravel-Binput
 * @author     Graham Campbell
 * @copyright  Copyright 2013 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Binput/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Binput
 */
abstract class AbstractFacadeTestCase extends AbstractTestCase
{
    use FacadeTestCaseTrait;

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
