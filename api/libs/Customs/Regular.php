<?php

namespace libs\Customs;

class Regular
{

    // 只允許"正整數" --不允許0 負數 小數點
    public static function PositiveInt($str)
    {
        if (preg_match('/^[1-9]\d*$/', $str)) {
            return true;
        }
    }

    // 只允許"正整數"及"空值" --不允許0 負數 小數點
    public static function PositiveIntEmpty($str)
    {
        if (preg_match('/^(|[1-9]\d*)$/', $str)) {
            return true;
        }
    }
}
