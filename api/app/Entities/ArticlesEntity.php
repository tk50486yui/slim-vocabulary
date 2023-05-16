<?php

namespace app\Entities;

use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
 **/

class ArticlesEntity
{
    private $arti_title;
    private $arti_content;
    private $arti_order; // int
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
        $this->arti_title = $data['arti_title'] ?? null;
        $this->arti_content = $data['arti_content'] ?? null;
        $this->arti_order = $data['arti_order'] ?? null;
        $this->cate_id = $data['cate_id'] ?? null;
    }

    /* 基本資料格式 以資料表允許格式為主 */
    public function validate()
    {
        // NOT NULL TEXT欄位 (不嚴格篩選 只要非空值就好)
        if (!VH::notNullText($this->arti_title)) {
            return false;
        }

        // 允許 null 的int
        if (!VH::acceptNullInt($this->arti_order)) {
            return false;
        }

        // 外鍵格式檢查 (外鍵是主鍵格式 所以用主鍵格式檢查)
        if (!VH::idType($this->cate_id)) {
            return false;
        }

        return true;
    }

    /* 全部驗證完後 設定預設值 */
    public function setDefault()
    {
        $this->arti_order = is_numeric($this->arti_order) ? (int)$this->arti_order : 1;
        $this->cate_id = is_numeric($this->cate_id) ? (int)$this->cate_id : null;
    }

    public function toArray()
    {
        return [
            'arti_title' => $this->arti_title,
            'arti_content' => $this->arti_content,
            'arti_order' => $this->arti_order,
            'cate_id' => $this->cate_id
        ];
    }
}
