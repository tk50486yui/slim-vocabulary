<?php

namespace core;

use \RedBeanPHP\R as R;
use Dotenv\Dotenv;

class Model
{
    public static function begin()
    { 
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $dbHost = $_ENV['DB_HOST'];
        $dbPort = $_ENV['DB_PORT'];
        $dbName = $_ENV['DB_NAME'];
        $dbUser = $_ENV['DB_USER'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        R::setup(
            'pgsql:host=' . $dbHost . 
            ';port='.$dbPort.
            ';dbname=' .$dbName,
            $dbUser,
            $dbPassword
        );
        R::freeze(true); 
        
    }
}