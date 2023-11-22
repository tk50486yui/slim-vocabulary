<?php

namespace app\Entities;

use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
 **/

class WordsGroupsEntity
{
    private $wg_name; 

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
   
    public function populate($data)
    {
        $this->wg_name = $data['wg_name'] ?? null;       
    }
 
    public function validate()
    {
        // NOT NULL TEXT欄位
        if (!VH::notNullText($this->wg_name)) {
            return false;
        }

        return true;
    }

    public function setDefault()
    {
        // ..
        return true;
    }

    public function toArray()
    {
        return [
            'wg_name' => $this->wg_name
        ];
    }
}
