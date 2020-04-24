<?php

namespace Infrastructure;

class Database
{
    private $connection;

    public static function mysqli()
    {
        $config = \Isystems\Config\Database::getCredentials();
        $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['db'])
                        or die('Cannot connect to database');

        return new self($connection);
    }

    public function __construct($connection)
    {
        $this->connection = $connection;
        mysqli_query($this->connection, "SET NAMES utf8");
    }

    public function getProducers()
    {
        $results = mysqli_query(
            $this->connection,
            mysqli_real_escape_string(
                $this->connection,
                "SELECT * FROM `producers`;"
            )
        );

        $producers = [];

        while($row = mysqli_fetch_assoc($results)) {
            $producers[] = $row;
        }

        return $producers;
    }

    public function postProducer(array $producer)
    {
        $name = mysqli_real_escape_string($this->connection, $producer['name']);
        $siteUrl = $producer['site_url'] === null ? null : mysqli_real_escape_string($this->connection, $producer['site_url']);
        $logo = $producer['logo_filename'] === null ? null : mysqli_real_escape_string($this->connection, $producer['logo_filename']);
        $sourceId = mysqli_real_escape_string($this->connection, $producer['source_id']);
        $ordering = mysqli_real_escape_string($this->connection, $producer['ordering']);

        mysqli_query(
            $this->connection,
            "INSERT INTO `producers` (`name`, `page`, `logo`, `priority`, `ordering`, `source_id`) VALUES('{$name}', '{$siteUrl}', '{$logo}', 'low', '{$ordering }', '{$sourceId}');"
        );
    }

    public function insertedId()
    {
        return mysqli_insert_id($this->connection);
    }
}
