<?php

namespace Isystems\Config;

class Auth {
    public static function getCredentials() {
        $config = array(
            'url' => '',// 'http://grzegorz.demos.i-sklep.pl/rest_api/shop_api/v1',
            'authorizationData' => 'rest:vKTUeyrt'
        );
        return $config;
    }
}