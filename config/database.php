<?php

namespace Isystems\Config;

class Database
{
    private static $instance;
    private $config;
    
    private function __construct()
    {
        $this->config = array(
            'host' => 'localhost',
            'user' => 'mnhck91_producer',
            'password' => '2ky0fBfB',
            'db' => 'mnhck91_producer',
        );
    }
    
    public function __clone()
    {
    }
    
    public static function getCredentials() {
        if (null === self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance->getConfiguration();
    }
    
    private function getConfiguration()
    {
        return $this->config;
    }
}
