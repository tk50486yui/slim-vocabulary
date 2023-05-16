<?php

namespace app\Entities;

use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
 **/

class TagsEntity
{
    private $ts_name;
    private $ts_description;
    private $ts_storage; // bool
    private $ts_level; // int
    private $ts_sort_order; // int
    private $ts_parent_id; // 外鍵

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
        $this->ts_name = $data['ts_name'] ?? null;
        $this->ts_description = $data['ts_description'] ?? null;
        $this->ts_storage = $data['ts_storage'] ?? null;
        $this->ts_level = $data['ts_level'] ?? null;
        $this->ts_sort_order = $data['ts_sort_order'] ?? null;
        $this->ts_parent_id = $data['ts_parent_id'] ?? null;
    }

    /* 基本資料格式 以資料表允許格式為主 */
    public function validate()
    {
        // NOT NULL TEXT欄位 (不嚴格篩選 只要非空值就好)
        if (!VH::notNullText($this->ts_name)) {
            return false;
        }

        // 允許 null 的int
        if (!VH::acceptNullInt($this->ts_level)) {
            return false;
        }

        // 允許 null 的int
        if (!VH::acceptNullInt($this->ts_sort_order)) {
            return false;
        }

        // 外鍵格式檢查 (外鍵是主鍵格式 所以用主鍵格式檢查)
        if (!VH::idType($this->ts_parent_id)) {
            return false;
        }

        return true;
    }

    /* 全部驗證完後 設定預設值 */
    public function setDefault()
    {
        $this->ts_storage = is_bool($this->ts_storage) ? (bool)$this->ts_storage : true;
        $this->ts_level = is_numeric($this->ts_level) ? (int)$this->ts_level : 1;
        $this->ts_sort_order = is_numeric($this->ts_sort_order) ? (int)$this->ts_sort_order : 1;
        $this->ts_parent_id = is_numeric($this->ts_parent_id) ? (int)$this->ts_parent_id : null;
    }

    public function toArray()
    {
        return [
            'ts_name' => $this->ts_name,
            'ts_description' => $this->ts_description,
            'ts_storage' => $this->ts_storage,
            'ts_level' => $this->ts_level,
            'ts_sort_order' => $this->ts_sort_order,
            'ts_parent_id' => $this->ts_parent_id
        ];
    }
}
