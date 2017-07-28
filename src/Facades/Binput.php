<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Binput.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Binput\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the binput facade class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Binput extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'binput';
    }
}
