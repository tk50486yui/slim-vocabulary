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
    private $cate_parent_id; // 外鍵
    private $cate_level; // int
    private $cate_sort_order; // int

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
        $this->cate_name = $data['cate_name'] ?? null;
        $this->cate_parent_id = $data['cate_parent_id'] ?? null;
        $this->cate_level = $data['cate_level'] ?? null;
        $this->cate_sort_order = $data['cate_sort_order'] ?? null;
    }

    /* 基本資料格式 以資料表允許格式為主 */
    public function validate()
    {
        // NOT NULL TEXT欄位 (不嚴格篩選 只要非空值就好)
        if (!VH::notNullText($this->cate_name)) {
            return false;
        }

        // 允許 null 的int
        if (!VH::acceptNullInt($this->cate_level)) {
            return false;
        }

        // 允許 null 的int
        if (!VH::acceptNullInt($this->cate_sort_order)) {
            return false;
        }

        // 外鍵格式檢查 (外鍵是主鍵格式 所以用主鍵格式檢查)
        if (!VH::idType($this->cate_parent_id)) {
            return false;
        }

        return true;
    }

    /* 全部驗證完後 設定預設值 */
    public function setDefault()
    {
        $this->cate_parent_id = is_numeric($this->cate_parent_id) ? (int)$this->cate_parent_id : null;
        $this->cate_level = is_numeric($this->cate_level) ? (int)$this->cate_level : 1;
        $this->cate_sort_order = is_numeric($this->cate_sort_order) ? (int)$this->cate_sort_order : 1;
    }

    public function toArray()
    {
        return [
            'cate_name' => $this->cate_name,
            'cate_parent_id' => $this->cate_parent_id,
            'cate_level' => $this->cate_level,
            'cate_sort_order' => $this->cate_sort_order
        ];
    }
}
