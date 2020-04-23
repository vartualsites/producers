<?php

namespace Isystems\Vendor;

class Output {
    public static function setCode($code = 200) {
        http_response_code($code);
    }
}
