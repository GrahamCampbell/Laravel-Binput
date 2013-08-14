<?php namespace GrahamCampbell\Binput\Facades;

use Illuminate\Support\Facades\Input;

class Binput extends Input {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'binput'; }

}
