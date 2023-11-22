<?php

namespace app\Entities;

use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
 **/

class WordsTagsEntity
{
    private $ws_id;   // 外鍵
    private $ts_id;   // 外鍵

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
        $this->ws_id = $data['ws_id'] ?? null;
        $this->ts_id = $data['ts_id'] ?? null;
    }

    public function validate()
    {
        if (!VH::notNullText($this->ws_id)) {
            return false;
        }
        if (!VH::notNullText($this->ts_id)) {
            return false;
        }

        if (!VH::idType($this->ws_id)) {
            return false;
        }
        if (!VH::idType($this->ts_id)) {
            return false;
        }

        return true;
    }
    
    public function setDefault()
    {
        $this->ws_id = (int)$this->ws_id;
        $this->ts_id = (int)$this->ts_id;
    }

    public function toArray()
    {
        return [
            'ws_id' => $this->ws_id,
            'ts_id' => $this->ts_id
        ];
    }
}
