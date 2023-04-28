<?php

namespace core;

use \RedBeanPHP\R as R;
use \core\Config;

class Model
{
    public static function begin()
    { 
        R::setup(
            'pgsql:host=' . Config::DB_HOST . 
            ';port='.Config::DB_PORT.
            ';dbname=' . Config::DB_NAME,
            Config::DB_USER,
            Config::DB_PASSWORD
        );
        R::freeze(true); 
        
    }
}