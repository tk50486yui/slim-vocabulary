<?php

namespace app\Validations;

use libs\Customs\Regular;

class Validation
{  
    
    //  主鍵id格式檢查 INTEGER
    public static function validateID($id)
    {
        // 1. 先把布林過濾掉
        if (is_bool($id)) {
            return false;
        }
        
        // 2. 判斷id是否允許null及空值
        // 用 === 過濾掉 0 1 避免判斷錯誤
        if ($id === null || $id === '') {
            return false;
        }      

        // 3. 若id有值 則檢查其資料格式 不符合就直接過濾掉
        if (!Regular::PositiveInt($id)) {
            return false;
        }

        return true;
    }
}