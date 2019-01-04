<?php

namespace Isystems\Config;

class Database {
    public static function getCredentials() {
        $config = array(
            'host' => '',
            'user' => '',
            'password' => '',
            'db' => '',
        );

        return $config;
    }
}
