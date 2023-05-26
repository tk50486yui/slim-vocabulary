<?php

namespace app\Entities;

use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
 **/

class CategoriesEntity
{
    private $cate_name;
    private $cate_parent_id;   // 外鍵
    private $cate_level;       // int
    private $cate_order;  // int

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
        $this->cate_name = $data['cate_name'] ?? null;
        $this->cate_parent_id = $data['cate_parent_id'] ?? null;
        $this->cate_level = $data['cate_level'] ?? null;
        $this->cate_order = $data['cate_order'] ?? null;
    }

    public function validate()
    {
        // NOT NULL TEXT欄位
        if (!VH::notNullText($this->cate_name)) {
            return false;
        }

        // 允許 null 的 int
        if (!VH::acceptNullInt($this->cate_level)) {
            return false;
        }

        // 允許 null 的 int
        if (!VH::acceptNullInt($this->cate_order)) {
            return false;
        }

        // 外鍵格式檢查
        if (!VH::idType($this->cate_parent_id)) {
            return false;
        }

        return true;
    }
   
    public function setDefault()
    {
        $this->cate_parent_id = is_numeric($this->cate_parent_id) ? (int)$this->cate_parent_id : null;
        $this->cate_level = is_numeric($this->cate_level) ? (int)$this->cate_level : 1;
        $this->cate_order = is_numeric($this->cate_order) ? (int)$this->cate_order : 1;
    }

    public function toArray()
    {
        return [
            'cate_name' => $this->cate_name,
            'cate_parent_id' => $this->cate_parent_id,
            'cate_level' => $this->cate_level,
            'cate_order' => $this->cate_order
        ];
    }
}
