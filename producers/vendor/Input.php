<?php

namespace Isystems\Vendor;

class Input {
    public static function getRequestEndpoints() {
        $class = $method = '';
        $params = null;
        $endpoints = explode('/', str_replace(LOCAL_URI, '', $_SERVER['REQUEST_URI']));

        if(isset($endpoints[0]))
            $class = $endpoints[0];
        if(isset($endpoints[1]))
            $method = $endpoints[1];
        if(isset($endpoints[2]))
            $params = $endpoints[2];

        return (object) array('class' => $class, 'method' => $method, 'params' => $params);
    }
}
