<?php

namespace app\Entities;
use app\Validators\ValidatorHelper as VH;

/**   
 * 將傳進來的資料注入給定義好的Entity，避免出現找不到key的情況
 * populate方法只用來注入資料，並將未定義的key預設成null
 * validate方法用來驗證基本資料格式，不做其他複雜驗證
**/ 

class ArticlesWordsEntity
{    
    private $arti_id; // 外鍵
    private $ws_id;   // 外鍵
 
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
        $this->arti_id=$data['arti_id'] ?? null;
        $this->ws_id=$data['ws_id'] ?? null;
      
    }

    /* 基本資料格式 以資料表允許格式為主 */
    public function validate()
    {       
        if (!VH::notNullText($this->arti_id)) {
            return false;
        } 
        if (!VH::notNullText($this->ws_id)) {
            return false;
        }
     
        if(!VH::idType($this->arti_id)){
            return false;
        }
        if(!VH::idType($this->ws_id)){
            return false;
        }

        return true;
    }

     /* 全部驗證完後 設定轉換格式 */
     public function setDefault()
     {
         $this->arti_id=(int)$this->arti_id;
         $this->ws_id=(int)$this->ws_id;
       
     }

    public function toArray()
    {
        return [         
            'arti_id' => $this->arti_id,           
            'ws_id' => $this->ws_id
        ];
    }
}
