<?php namespace GrahamCampbell\Binput\Classes;

use Illuminate\Illuminate\Http\Request;
use GrahamCampbell\Security\Classes\Security;

class Binput extends Request {

    protected $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

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
            $value = $security->xss_clean($value);
        }

        return $value;
    }
}
