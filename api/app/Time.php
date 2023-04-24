<?php

namespace app;

use DateTime;
use DateTimeZone;
class Time
{    
    public static function getNow()
    { 
        $now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
        $local = $now->setTimeZone(new DateTimeZone('Asia/Taipei'));
        return $local->format("Y-m-d H:i:s.u");
    }    
}