<?php

namespace app\Validators;

use libs\Regular;

class ValidatorHelper
{

    //  id格式檢查 INTEGER
    public static function idType($id)
    {
        // 1. 先把布林過濾掉 is_bool()判斷0或1會是數字 
        if (is_bool($id)) {
            return false;
        }

        // 2. 判斷id是否允許null及空值
        // 用 === 過濾掉 0 1 避免判斷錯誤
        if ($id === null || $id === '') {
            return true;
        }

        // 3. 若id有值 則檢查其資料格式 不符合就直接過濾掉
        if (!Regular::PositiveInt($id)) {
            return false;
        }

        return true;
    }

    public static function notNullText($text)
    {        
        // NOT NULL TEXT欄位 (不嚴格篩選 只要非null非空值就好)
        if (is_bool($text) || empty($text)) {
            return false;
        }

        return true;
    }
 
    public static function acceptNullZeroInt($num)
    {
        // 1. 先把布林過濾掉 is_bool()判斷0或1會是數字 
        if (is_bool($num)) {
            return false;
        }

        // 2. 允許null及空值
        if ($num === null || $num === '') {
            return true;
        }

        // 3. 若有值 則檢查其資料格式 不符合就直接過濾掉 
        if (!Regular::PositiveIntZero($num)) {
            return false;
        }

        return true;
    }
}
