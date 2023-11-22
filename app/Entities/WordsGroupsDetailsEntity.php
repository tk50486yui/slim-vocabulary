<?php

namespace app\Entities;

use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
 **/

class WordsGroupsDetailsEntity
{
    private $ws_id;       // 外鍵
    private $wg_id;       // 外鍵
    private $wgd_content;

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
        $this->wg_id = $data['wg_id'] ?? null;
        $this->wgd_content = $data['wgd_content'] ?? null;
    }

    public function validate()
    {
        if (!VH::notNullText($this->ws_id)) {
            return false;
        }
        if (!VH::notNullText($this->wg_id)) {
            return false;
        }

        if (!VH::idType($this->ws_id)) {
            return false;
        }
        if (!VH::idType($this->wg_id)) {
            return false;
        }

        return true;
    }

    public function setDefault()
    {
        $this->ws_id = (int)$this->ws_id;
        $this->wg_id = (int)$this->wg_id;
    }

    public function toArray()
    {
        return [
            'ws_id' => $this->ws_id,
            'wg_id' => $this->wg_id,
            'wgd_content' => $this->wgd_content
        ];
    }
}
