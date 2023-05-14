<?php

namespace libs;

class Regular
{

    // 允許 "正整數" --不允許0 負數 小數點
    public static function PositiveInt($str)
    {
        if (preg_match('/^[1-9]\d*$/', $str)) {
            return true;
        }
    }

    // 允許 "正整數" "0" --不允許負數 小數點 前綴為0的數字
    public static function PositiveIntZero($str)
    {
        if (preg_match('/^(0|[1-9]\d*)$/', $str)) {
            return true;
        }
    }

    // 允許 "正整數" "空值" --不允許0 負數 小數點
    public static function PositiveIntEmpty($str)
    {
        if (preg_match('/^(|[1-9]\d*)$/', $str)) {
            return true;
        }
    }

    // 允許"正整數" "0" "空值" "null" "NULL" --不允許負數 小數點 前綴為0的數字
    public static function PositiveIntNullEmpty($str)
    {
        if (preg_match('/^(|0|[1-9]\d*|null|NULL)$/', $str)) {
            return true;
        }
    }
}
