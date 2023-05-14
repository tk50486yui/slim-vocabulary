<?php

namespace app\Entities;
use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
**/ 

class WordsEntity
{
    private $ws_name;
    private $ws_definition;
    private $ws_pronunciation;
    private $ws_slogan;
    private $ws_description;
    private $ws_is_important;// bool
    private $ws_is_common; // bool
    private $ws_forget_count; // int
    private $ws_display_order; // int
    private $cate_id; // 外鍵

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /* 將資料注入至Entity */
    public function populate($data)
    {       
        $this->ws_name=$data['ws_name'] ?? null;        
        $this->ws_definition=$data['ws_definition'] ?? null;
        $this->ws_pronunciation=$data['ws_pronunciation'] ?? null;
        $this->ws_slogan=$data['ws_slogan'] ?? null;
        $this->ws_description=$data['ws_description'] ?? null;
        $this->ws_is_important=$data['ws_is_important'] ?? null;
        $this->ws_is_common=$data['ws_is_common'] ?? null;
        $this->ws_forget_count=$data['ws_forget_count'] ?? null;
        $this->ws_display_order=$data['ws_display_order'] ?? null;
        $this->cate_id=$data['cate_id'] ?? null;
    }

    /* 驗證基本資料格式 */
    public function validate()
    {
        // NOT NULL TEXT欄位 (不嚴格篩選 只要非空值就好)
        if (!VH::notNullText($this->ws_name)) {
            return false;
        }   

        // 允許 null 0 的int
        if(!VH::acceptNullZeroInt($this->ws_forget_count)){
            return false;
        }

        // 允許 null 0 的int
        if(!VH::acceptNullZeroInt($this->ws_display_order)){
            return false;
        }
          
        // 外鍵格式檢查 (外鍵是主鍵格式 所以用主鍵格式檢查)
        if(!VH::idType($this->cate_id)){
            return false;
        }

        return true;
    }
}
