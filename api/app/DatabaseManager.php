<?php
namespace app;

use RedBeanPHP\R;
use app\Msg;

class DatabaseManager
{
    public static function checkConnection()
    {
        if (!R::testConnection()) {           
            return false;
        }
        return true;
    }
}