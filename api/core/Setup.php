<?php

namespace core;

use core\Model as Connet;
use \RedBeanPHP\R as R;

class Setup{

    public function RedBean()
    {
        
        Connet::begin();

        // 定義 xdispense 因為 Redbean 不允許資料庫名稱有 _ 及 大寫字母
        R::ext('xdispense', function($type) {
            return R::getRedBean()->dispense($type);
        });
    }

}