<?php

namespace Core\database;

use PDO;

class Connection
{
    public static function make ($config)
    {
        $type = $config['type'];
        $database = $config[ $type ];

        return new PDO(
            $database['connection'] . ';port:' . $database['port'] . ';dbname=' . $database['dbname'] . ';charset=' .
            $database['charset'],
            $config[ $type ]['username'],
            $config[ $type ]['password'],
            $config[ $type ]['options']
        );
    }
}