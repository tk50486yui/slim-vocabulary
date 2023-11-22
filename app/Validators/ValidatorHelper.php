<?php

namespace app\Validators;

use libs\Regular;

class ValidatorHelper
{

    public static function idType($id)
    {
        if (is_bool($id)) {
            return false;
        }
       
        if (SELF::acceptNullEmpty($id)) {
            return true;
        }
    
        if (!Regular::PositiveInt($id)) {
            return false;
        }

        return true;
    }

    public static function notNullText($text)
    {    
        if (is_bool($text) || empty($text)) {
            return false;
        }

        return true;
    }

    public static function acceptNullInt($num)
    {      
        if (is_bool($num)) {
            return false;
        }
      
        if (SELF::acceptNullEmpty($num)) {
            return true;
        }
      
        if (!Regular::PositiveInt($num)) {
            return false;
        }

        return true;
    }
 
    public static function acceptNullZeroInt($num)
    {      
        if (is_bool($num)) {
            return false;
        }
      
        if (SELF::acceptNullEmpty($num)) {
            return true;
        }
      
        if (!Regular::PositiveIntZero($num)) {
            return false;
        }

        return true;
    }

    public static function acceptNullEmpty($id)
    {  
        if ($id === null || $id === '') {
            return true;
        }
        return false;
    }
}
