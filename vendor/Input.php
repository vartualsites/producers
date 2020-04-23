<?php

namespace Isystems\Vendor;

class Input {
    public static function getRequestEndpoints() {
        $class = $method = '';
        $params = null;
        $endpoints = explode('/', $_SERVER['REQUEST_URI']);

        if(isset($endpoints[1]))
            $class = $endpoints[1];
        if(isset($endpoints[2]))
            $method = $endpoints[2];
        if(isset($endpoints[3]))
            $params = $endpoints[3];

        return (object) array('class' => $class, 'method' => $method, 'params' => $params);
    }
}
