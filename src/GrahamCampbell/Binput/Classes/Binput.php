<?php namespace GrahamCampbell\Binput\Classes;

use Illuminate\Illuminate\Http\Request;
use GrahamCampbell\Security\Facades\Security;

class Binput extends Request {

    public function get($key = null, $default = null, $trim = true, $xss_clean = true) {
        $input = $this->all();

        if (is_null($key)) {
            return array_merge($input, $this->query());
        }

        $value = array_get($input, $key);

        if (is_null($value)) {
            return array_get($this->query(), $key, $default);
        }

        if($trim === true) {
            $value = trim($value);
        }

        if($xss_clean === true) {
            $value = Security::xss_clean($value);
        }

        return $value;
    }
}
